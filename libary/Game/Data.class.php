<?php
/**
*
* Daten-Klasse, von ihr erben alle Klassen, die Daten brauchen
*	Tochter-Klassen müssen das DataVars-Trait benutzen.
* Datum: 20. Dezember 2012
*
**/
namespace Game;

class Data extends \Core\Data {
	/**
	* Lädt alle Daten-Dateien, die im Ordner liegen.
	*
	* @param array $dataFiles - Welche Dateien überhaupt? [optional]
	**/
	public static function loadAllDataFiles($dataFiles = array()) {
		$dataFiles += array('Season','Capacity','Train','Station','Path', 'TaskModel');
		
	    parent::loadAllDataFiles($dataFiles);
	}
}
?>