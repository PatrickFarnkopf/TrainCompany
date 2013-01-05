<?php
/**
*
* Wenn eine MainInstance automatisch geöffnet werden soll, dieses Trait einbinden
*
* Datum: 27. Dezember 2012
*
**/
namespace Core\Cache;

trait AutoMainInstance {
	/**
	* Gibt die Hauptinstanz zurück, falls vorhanden. Wenn nicht wird eine neue erstellt
	*
	* @return static - Die Haupinstanz dieser Klasse
	**/
	public static function mainInstance() {
		if(!static::existMainInstance()) static::setMainInstance(new static());
		
		return static::$mainInstance;
	}
}
?>