<?php	
/**
*
* Interface, das in jede Daemon-Aufgaben-Klasse eingefügt werden muss
* Datum: 4. Dezember 2012
*
**/
namespace Daemon;

interface Task {
	/**
	* Muss die Aufgabe ausgeführt werden?
	*
	* @return bool - Ja/Nein?
	**/
	public function hasToRun();

	/**
	* Führt den DaemonTask aus.
	**/
	public function run();
}
?>