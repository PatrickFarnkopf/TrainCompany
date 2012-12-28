<?php
/**
*
* Hautpklasse der Einstellungen
* Datum: 5. November 2012
*
**/
namespace Script; class Modules_Game_Settings_mainScript_php extends \Core\Module\Extender  {
	public function __construct() {
	
		$this->mi()->addVarCache('siteTitle', 'Einstellungen');
		$this->mi()->addVarCache('showError', false);
		$this->mi()->addVarCache('showSuccess', false);
		
		$settingModules = array('Game_Settings_General'=>'E-Mail/Passwort ändern',
								'Game_Settings_Groups'=>'Fahrzeuggruppen anpassen');
								
		if(\Config\DEBUG) $settingModules['Game_Settings_Debug'] = 'Debug-Informationen';
		$this->mi()->addVarCache('settingModules', $settingModules);
	}
}