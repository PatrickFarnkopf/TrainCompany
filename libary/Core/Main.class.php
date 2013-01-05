<?php
/**
*
* Diese Klasse ist die Haupt-Klasse, sie l�dt immer die erforderlichen Daten nach,
* um die angeforderte Seite richtig darstellen zu k�nnen.
* Datum: 27. Juni 2012
*
**/
namespace Core;

abstract class Main {
	/**
	* Die Konstrukt-Methode, die alles weitere ausf�hrt.
	**/
	public function __construct() {
		// Callback f�r die Main-Instance-Klasse setzen
		Autoload::registerBeforeCallback(['Core\MainInstance', 'callback']);
		// Callback f�r die Daten-Klassen-Erstellen
		Autoload::registerAfterCallback(['Core\Data', 'callback']);
	
		// Zeitzone setzen
		date_default_timezone_set(\Config\TIME_ZONE);
		
		// Setzt den Header
		new Header();
		
		// MySQL-Verbindung aufbauen (Au�er das Programm ist noch nicht installiert)
		if(\Config\INSTALLED) {
			// Verbindung aufbauen
			MySQL::connectWithConfigData();
			// Escape-String-Alias erstellen
			Alias::forFunction([i::MySQL(), 'escapeString'], 'escapeMySQL');
		}
	}
	
	/**
	* Instanziert und Startet die Klasse
	**/
	public static function startAll() {
		// Instance �ffnen
		$instance = new static();
		// Start-Methode aufrufen
		$instance->start();
	}
	
	/**
	* �Startet� die Aufgaben dieser Klasse.
	**/
	abstract public function start();
	
	/**
	* Berechnet die Generierungszeit.
	*	Ohh, dank awesome neuer Server-Variable in PHP 5.4 geht das jetzt viel cooler! :3
	*
	* @return string - Zeit als String
	**/
	public static function getGenTime() {
		$startTime = $_SERVER['REQUEST_TIME_FLOAT'];
		$endTime = microtime(true);
	
		return Format::unit(Format::number(($endTime - $startTime) * 1000,2),'ms');
	}
}
?>