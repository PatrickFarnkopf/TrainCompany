<?php
/**
*
* Die Haupt-Modul-Klasse für das intere Spiel. Überprüft z.B. die Sitzung auf Gültigkeit.
* Datum: 17. Oktober 2012
*
**/
namespace Script; class Modules_Game_mainScript_php extends \Core\Module\Extender  {
	public function __construct() {
		// Template-Set umstellen
		$this->mi()->setTemplateSet('game');
		$this->mi()->addVarCache('showError', false);
		$this->mi()->addVarCache('showSuccess', false);
		
		$this->checkSession();
		$this->addVarCacheFunctions();
	}
	
	/**
	* Überprüft ob eine Sitzung vorhanden ist und sie valid ist.
	**/
	private function checkSession() {
		if(\Core\Session::existMainInstance()) {
			$currentSession = \Core\i::Session();
			if($currentSession->recheckLoginData()) return;
		}
		
		// Keine valide Sitzung? Erstmal zur Startseite.
		\Core\Module::goToModule('Start', array('currentSession'=>'invalid'));
	}
	
	/**
	* Fügt dem Var-Cache ein paar wichtige Funktionen hinzu.
	**/
	private function addVarCacheFunctions() {
		$currentUserInstance = function() {
			return $this->ui();
		};
		$this->mi()->addVarCache('currentUserInstance',$currentUserInstance,true);
	
		$currentUserName = function() {
			return $this->ui()->getUserName();
		};
		$this->mi()->addVarCache('currentUserName',$currentUserName,true);
		
		$currentUserMail = function() {
			return $this->ui()->getUserMail();
		};
		$this->mi()->addVarCache('currentUserMail',$currentUserMail,true);
		
		$currentUserPlops = function() {
			return $this->ui()->getPlops();
		};
		$this->mi()->addVarCache('currentUserPlops',$currentUserPlops,true);
		
		$currentUserNotifications = function() {
			return $this->ui()->listNotifications();
		};
		$this->mi()->addVarCache('currentUserNotifications',$currentUserNotifications,true);
		
		$currentDate = function() {
			return \Game\Play::getCurrentSeasonAndYearString();
		};
		$this->mi()->addVarCache('currentDate',$currentDate,true);
		
		$timeAtNextSeason = function() {
			return time()+\Game\Play::timeTillNextSeason();
		};
		$this->mi()->addVarCache('timeAtNextSeason',$timeAtNextSeason,true);
	}
}
?>