<?php
/**
*
* Den Spieler ausloggen
* Datum: 17. Oktober 2012
*
**/
namespace Script; class Modules_Game_Logout_script_php extends \Core\Module\Extender  {
	/**
	* 	Logt den Benutzer aus.
	**/
	public function __construct() {
		// Session löschen
		\Core\Session::unsetMainInstance();
		// Zur Startseite weiterleiten
		\Core\Module::goToModule('Start');
	}
}
?>