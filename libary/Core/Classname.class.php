<?php
/**
*
* „Parst“ einen Klassennamen und gibt Informationen über ihn zurück
*
* Datum: 20.12.2012
*
**/
namespace Core;

class Classname {
	private $classname, $namespace;
	
	/**
	* Nimmt einen Klassennamen an und parst ihn.
	*
	* @param string $classname
	**/
	public function __construct($classname) {
		// Klassennamen aufteilen
		$classnameParts = explode('\\', $classname);
		
		// Letztes Element ist der Klassenname
		$lastElement = count($classnameParts)-1;
		$this->classname = $classnameParts[$lastElement];
		
		// Alle andere Elemente sind der Namespace
		unset($classnameParts[$lastElement]);
		$this->namespace = $classnameParts;
	}
	
	/**
	* Gibt den Klassennamen zurück. (Ohne Namespace)
	*
	* @return string
	**/
	public function getClassname() {
		return $this->classname;
	}
	
	/**
	* Gibt die Klasse mit vollem Namen zurück (Inklusive Namespace)
	*
	* @return string
	**/
	public function getFullClassname() {
		return $this->getNamespaceAsString().'\\'.$this->classname;
	}
	
	/**
	* Classname als String
	*
	* @return string
	**/
	public function __toString() {
		return $this->getFullClassname();
	}
	
	/**
	* Gibt den Namespace als Array zurück.
	*
	* @return array
	**/
	public function getNamespace() {
		return $this->namespace;
	}
	
	/**
	* Gibt den Namespace als String zurück
	*
	* @return string
	**/
	public function getNamespaceAsString() {
		return implode('\\', $this->namespace);
	}
}
?>