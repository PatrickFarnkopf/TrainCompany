<?php
/**
*
* Speichert Daten über einen Modul-Namen.
* Datum: 23.12.2012
*
**/
namespace Core\Module;

class Name {
	private $moduleName;
	
	/**
	* Nimmt den gewünschten Name entgegen
	*
	* @param string $moduleName
	**/
	public function __construct($moduleName) {
		$this->moduleName = $moduleName;
	}
	
	/**
	* Gibt die einzelne Segmente des Module-Namen zurück
	*
	* @return array
	**/
	public function getSegments() {
		// Teilt den String auf in ein Array.
		return explode('_', $this->moduleName);
	}
	
	/**
	* Gibt die Segmente als String/Pfad zurück.
	*
	* @return string
	**/
	public function getSegmentsAsPath() {
		return implode('/', $this->getSegments()).'/';
	}
	
	/**
	* Gibt die „Eltern“-Segmente zurück.
	*
	* @return array
	**/
	public function getParentSegments() {
		// Alle Segmente bekommen
		$segments = $this->getSegments();
		// ID des letzten Segments herausfinden
		$lastID = count($segments)-1;
		// Letztes Element löschen
		unset($segments[$lastID]);
		
		// Die restlichen Segmente zurückgeben
		return $segments;
	}
	
	/**
	* Gibt die „Eltern“-Segmente als String zurück
	*
	* @return string
	**/
	public function getParentSegmentsAsString() {
		return implode('_', $this->getParentSegments());
	}
	
	/**
	* Gibt die „Eltern“-Segmente als neue Klasse zurück.
	*
	* @return \Core\Module\Name
	**/
	public function getParentSegmentsAsObject() {
		// Den String der Eltern-Elemente bekommen
		$paranSegmentString = $this->getParentSegmentsAsString();
		// Der String ist leer? NULL zurückgeben
		if(empty($paranSegmentString)) return NULL;
		// Sonst das Objekt zurückgeben
		return new self($this->getParentSegmentsAsString());
	}

	/**
	* Das letzte Segment zurückgeben.
	*
	* @param $main - Main-Klasse? [optional]
	* @return string
	**/
	public function getMainSegment($main = false) {
		// Alle Segmente bekommen
		$segments = $this->getSegments();
		// ID des letzten Segments herausfinden
		$lastID = count($segments)-1;
		
		// Das letzte Segment zurückgeben
		return $segments[$lastID].($main ? 'Main':'');
	}
	
	/**
	* Gibt den Pfad zu einer bestimmten Datei zurück.
	*
	* @param $type - Der Typ der Datei [optional]
	* @param $main - Main-Klasse oder -Template? [optional]
	**/
	public function getPathToFile($type = 'script', $main = false) {
		// Segmente zusammenfügen
		$path = $this->getSegmentsAsPath();
		// Haupt-Klasse oder -Template?
		if($main) {
			$path .= 'main';
			// Dann muss der erste Buchstaben des Types groß geschrieben werden. Bsp.: mainTemplate
			$type = ucfirst($type);
		}
		// Endung anfügen
		$path .= $type.'.php';
		
		// Pfad zurückgeben
		return $path;
	}
	
	/**
	* Gibt den vollen Modulenamen zurück
	*
	* @return string
	**/
	public function __toString() {
		return $this->moduleName;
	}
}
?>