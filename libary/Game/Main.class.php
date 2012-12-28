<?php
/**
*
* Diese Klasse ist die Haupt-Klasse, sie lŠdt immer die erforderlichen Daten nach,
* um die angeforderte Seite richtig darstellen zu kšnnen.
* Datum: 27. Juni 2012
*
**/
namespace Game;

class Main extends \Core\Main {
	/**
	* Die Konstrukt-Methode, die alles weitere ausfŸhrt.
	**/
	public function __construct() {
		parent::__construct();
		
		// Daten-Objekte einbinden
		Data::loadAllDataFiles();

		// Session šffnen
		session_start();
	}
	
	/**
	* Startet das Skript
	**/
	public function start() {
		// Modul-Instanz šffnen
		$moduleInstance = new \Core\Module(); 		
		$moduleInstance->open();
	}
}
?>