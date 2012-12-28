<?php
if(!defined('INC')) exit;
/**
*
* Installations-Modul-Klasse
* Datum: 19. Oktober 2012
*
**/
class installModule {
	private $installationInstance;

	public function __construct() {
		if(INSTALLED) Module::goToModule('start');
	
		$options = cmi()->getVarCache('options');
		cmi()->addVarCache('siteTitle', 'Installation');
		cmi()->addVarCache('showError', false);
		
		cmi()->addVarCache('mysqlServer', isset($_POST['mysqlServer']) ? $_POST['mysqlServer'] : '');
		cmi()->addVarCache('mysqlUser', isset($_POST['mysqlUser']) ? $_POST['mysqlUser'] : '');
		cmi()->addVarCache('mysqlPass', isset($_POST['mysqlPass']) ? $_POST['mysqlPass'] : '');
		cmi()->addVarCache('mysqlDatabase', isset($_POST['mysqlDatabase']) ? $_POST['mysqlDatabase'] : '');
		cmi()->addVarCache('createDatabase', isset($_POST['createDatabase']) ? true : false);
		cmi()->addVarCache('debugMode', isset($_POST['debugMode']) ? true : false);
		
		$this->installationInstance = new Install();
		
		cmi()->addVarCache('knownTimeZones', $this->installationInstance->getTimeZones());
		cmi()->addVarCache('currentTimeZone', isset($_POST['currentTimeZone']) ? $_POST['currentTimeZone'] : TIME_ZONE);
		
		try {
			$this->installationInstance->systemCheck();
		
			cmi()->addVarCache('badStatus', false);
			cmi()->addVarCache('statusString', "Der Server scheint alle Systemvorraussetzungen zu erfüllen.");
		} catch (HumanException $exception) {
			cmi()->addVarCache('badStatus', true);
			cmi()->addVarCache('statusString', Format::string($exception->getMessage()));
		}
		
		if(!cmi()->getVarCache('badStatus') && isset($options['writeConfiguration']) && $options['writeConfiguration'] == true)
			$this->writeConfigurations();
	}
	
	/**
	* Überprüft die eingegeben Daten und schreibt die Konfiguration, falls alles korrekt war.
	**/
	private function writeConfigurations() {
		try {
			$this->installationInstance->setDebugMode(cmi()->getVarCache('debugMode'));
		
			$this->installationInstance->setTimeZone(cmi()->getVarCache('currentTimeZone'));
			if (!$this->installationInstance->checkTimeZone())
				throw new HumanException('Die ausgewählte Zeitzone existiert nicht.');
				
			$this->installationInstance->setMySQLData(cmi()->getVarCache('mysqlServer'),cmi()->getVarCache('mysqlUser'),cmi()->getVarCache('mysqlPass'),cmi()->getVarCache('mysqlDatabase'));
			$this->installationInstance->checkMySQLData(cmi()->getVarCache('createDatabase'));
			
			$this->installationInstance->createMySQLTables();
			$this->installationInstance->writeConfig();
		
			CacheFile::clearCache();
		
			Module::goToModule('start', array('installationSuccessfull'=>true));
		} catch(HumanException $exception) {
			cmi()->addVarCache('showError', true);
			cmi()->addVarCache('errorString', $exception->getMessage());
		}
	}
}
?>