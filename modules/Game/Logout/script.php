<?php
/**
*
* Den Spieler ausloggen
* Datum: 17. Oktober 2012
*
**/
script {
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