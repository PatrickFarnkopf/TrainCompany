<?php
/**
*
* Diese Klasse ist die Haupt-Klasse, sie l�dt immer die erforderlichen Daten nach,
* um die angeforderte Seite richtig darstellen zu k�nnen.
* Datum: 27. Juni 2012
*
**/
namespace Game;

class Main extends \Core\Main {
	/**
	* Die Konstrukt-Methode, die alles weitere ausf�hrt.
	**/
	public function __construct() {
		parent::__construct();
		
		if(\Config\INSTALLED) {
			// Session �ffnen
			session_start();
		}
	}
	
	/**
	* Startet das Skript
	**/
	public function start() {
		// Modul-Instanz �ffnen
		$moduleInstance = new \Core\Module(); 		
		$moduleInstance->open();
	}
}
?>