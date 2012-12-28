<?php
/**
*
* Vereinheitlichung des Cachens von Haupt- und ID-Instanzen.
*	Bitte auch das CacheVars-Trait verwenden.
*
* Datum: 2. Dezember 2012
*
**/
namespace Core;

abstract class Cache {	
	/**
	* Gibt zurück, ob eine Instanz mit dieser ID existiert
	*
	* @param int $id - ID
	* @return bool - Existiert?
	**/
	public static function existInstanceFor($id) {
		return isset(static::$instances[$id]);
	}
	
	/**
	* Setzt eine Instanz für eine ID
	*
	* @param int $id - ID
	* @param Cache $instance - Die Instanz
	**/
	public static function setInstanceFor($id, Cache $instance) {
		static::$instances[$id] = $instance;
	}
	
	/**
    * Gibt eine Instanz für eine neue Klasse
    *
    * @param int $id - ID
    * @return static - Instanz die zu dieser ID passt.
    **/
    public static function instanceFor($id) {
		if(!static::existInstanceFor($id)) static::setInstanceFor($id, new static($id));

		return static::$instances[$id];
    }
	
	/**
	* Gibt zurück, ob eine Instanz als Hauptinstanz gesetzt ist.
	*
	* @return bool - Hauptinstanz vorhanden?
	**/
	public static function existMainInstance() {
		return is_object(static::$mainInstance);
	}
	
	/**
	* Gibt die Hauptinstanz zurück, falls vorhanden. Wenn nicht wird eine Exception geworfen
	*
	* @return static - Die Haupinstanz dieser Klasse
	**/
	public static function mainInstance() {
		if(!static::existMainInstance()) throw new \Exception('Die Klasse „'.get_called_class().'“ hat derzeit keine Hauptinstanz.',1000);
		
		return static::$mainInstance;
	}
	
	/**
	* Löscht die Hauptinstanz aus dem Speicher.
	**/
	public static function unsetMainInstance() {
		static::$mainInstance = NULL;
	}
	
	/**
	* Setzt eine Hauptinstanz
	*
	* @param Cache $mainInstance - Hauptinstanz
	**/
	public static function setMainInstance(Cache $mainInstance) {
		static::$mainInstance = $mainInstance;
	}
	
	/**
	* Gibt alle, für diese Klasse, vorhandenen Instanzen zurück.
	*	Sowohl die Haupt-Instanz als auch alle ID-Instanzen
	*
	* @return static
	**/
	public static function getAllInstances() {
		$instances = array_values(static::$instances);
		if(static::existMainInstance())
			$instances[] = static::mainInstance();
			
		return $instances;
	}
}