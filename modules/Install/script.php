<?php
/**
*
* Installations-Modul-Klasse
* Datum: 19. Oktober 2012
*
**/
script {
	private $installationInstance;

	public function __construct() {
		if(\Config\INSTALLED) \Core\Module::goToModule();
	
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Installation');
		
		$this->mi()->addVarCache('mysqlServer', isset($_POST['mysqlServer']) ? $_POST['mysqlServer'] : '');
		$this->mi()->addVarCache('mysqlUser', isset($_POST['mysqlUser']) ? $_POST['mysqlUser'] : '');
		$this->mi()->addVarCache('mysqlPass', isset($_POST['mysqlPass']) ? $_POST['mysqlPass'] : '');
		$this->mi()->addVarCache('mysqlDatabase', isset($_POST['mysqlDatabase']) ? $_POST['mysqlDatabase'] : '');
		$this->mi()->addVarCache('createDatabase', isset($_POST['createDatabase']) ? true : false);
		$this->mi()->addVarCache('debugMode', isset($_POST['debugMode']) ? true : false);
		
		$this->installationInstance = new \Core\Install();
		
		$this->mi()->addVarCache('knownTimeZones', $this->installationInstance->getTimeZones());
		$this->mi()->addVarCache('currentTimeZone', isset($_POST['currentTimeZone']) ? $_POST['currentTimeZone'] : \Config\TIME_ZONE);
		
		try {
			$this->installationInstance->systemCheck();
		
			$this->mi()->addVarCache('badStatus', false);
			$this->mi()->addVarCache('statusString', "Der Server scheint alle Systemvorraussetzungen zu erfüllen.");
		} catch (\HumanException $exception) {
			$this->mi()->addVarCache('badStatus', true);
			$this->mi()->addVarCache('statusString', Format::string($exception->getMessage()));
		}
		
		if(!$this->mi()->getVarCache('badStatus') && isset($options['writeConfiguration']) && $options['writeConfiguration'] == true)
			$this->writeConfigurations();
	}
	
	/**
	* Überprüft die eingegeben Daten und schreibt die Konfiguration, falls alles korrekt war.
	**/
	private function writeConfigurations() {
		try {
			$this->installationInstance->setDebugMode($this->mi()->getVarCache('debugMode'));
		
			$this->installationInstance->setTimeZone($this->mi()->getVarCache('currentTimeZone'));
			if (!$this->installationInstance->checkTimeZone())
				throw new HumanException('Die ausgewählte Zeitzone existiert nicht.');
				
			$this->installationInstance->setMySQLData($this->mi()->getVarCache('mysqlServer'),$this->mi()->getVarCache('mysqlUser'),$this->mi()->getVarCache('mysqlPass'),$this->mi()->getVarCache('mysqlDatabase'));
			$this->installationInstance->checkMySQLData($this->mi()->getVarCache('createDatabase'));
			
			$this->installationInstance->createMySQLTables();
			$this->installationInstance->writeConfig();
		
			\Core\CacheFile::clearCache();
		
			\Core\Module::goToModule(NULL, array('installationSuccessfull'=>true));
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
	}
}
?>