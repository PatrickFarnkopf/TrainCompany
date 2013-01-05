<?php
/**
*
* Verwaltet Objekte, die in einer Datenbank gespeichert sind
* Datum: 12. Dezember 2012
*
**/
namespace Core;

abstract class Manager extends Cache implements \Countable {
	use Cache\AutoMainInstance;

	const GROUPID_FIELDNAME = false;

	protected $objects = [], $unchangedObjects = [];
	protected $groupID, $tableActions;

	/**
	* Speichert eine TableActions in dem Objekt
	*
	* @param groupID - Eventuell eine ID für den Manager?
	**/
	public function __construct($groupID = false) {
		if($groupID === false) {
			if (static::existMainInstance()) throw new \Exception('Es gibt bereits eine Hauptinstanz dieses Managers.', 1100);
		} else {
			if (static::GROUPID_FIELDNAME === false) throw new \Exception('Dieser Manager kann keine ID-Instanzen öffnen.', 1103);
			if (static::existInstanceFor($groupID)) throw new \Exception('Es ist bereits eine Instanz für diese ID vorhanden.', 1102);
		}
			
		$this->groupID = $groupID;
		$this->setTableActions();
	}
	
	/**
	* Setzt die Table-Actions-Instanz
	**/
	abstract protected function setTableActions();
	
	/**
	* Speichert alle geänderten Objekte in der Datenbank
	**/
	public function __destruct() {
		static::unsetMainInstance();
		
		foreach($this->objects as $objectID => $currentObject) {
			if($currentObject == $this->unchangedObjects[$objectID]) continue;
			
			$contentArray = $this->getContentArrayForObject($currentObject);
			$queryObject = $this->tableActions->update($contentArray, ['id'=>$objectID]);
		}
	}
	
	/**
	* Gibt das Content-Array für ein Objekt zurück
	*
	* @param object $object - Das Objekt
	* @return array - Content-Array
	**/
    abstract protected function getContentArrayForObject($object);
	
	/**
	* Gibt den Where-String für „alle“ Objekte zurück
	*
	* @return string/array
	**/
	private function getAllWhereString() {
		if($this->groupID === false)
			return '';
		
		return [static::GROUPID_FIELDNAME => $this->groupID];
	}
	
	/**
	* Lädt alle Objekte aus der Datenbank
	**/
	public function loadAll($override = false) {
		$queryObject = $this->tableActions->select($this->getAllWhereString());
		
		$this->saveInInstance($queryObject);
	}
	
	/**
	* Speichert die geladenen Objekte in dieser Instanz
	*
	* @param MySQLQuery $queryObject - Die MySQL-Anfrage
	**/
	protected function saveInInstance(\Core\MySQL\Query $queryObject) {
		$newObjects = [];
		
		while($row = $queryObject->fetch()) {
			if($this->existObjectForID($row['id'])) continue;
			
			$existObject = null;
			if($this->groupID !== false) {
				$otherInstances = static::getAllInstances();
				foreach($otherInstances as $currentInstance) {
					if($currentInstance->existObjectForID($row['id'])) {
						// Irgendeine andere Instance dieses Managers hat dieses Objekt bereits. Nehmen wir das, kay?
						$existObject = $currentInstance->getObjectForID($row['id']);
						break;
					}
				}
			}
			
			if (is_object($existObject)) {
				$this->objects[$row['id']] = $existObject;
				// Nicht klonen, da ja bereits schon irgendeine andere Instanz diese Instanz speichert.
				$this->unchangedObjects[$row['id']] = $existObject;
			} else {
				$newObject = unserialize($row['object']);
			
				$this->objects[$row['id']] = $newObject;
				$this->unchangedObjects[$row['id']] = clone $newObject;
			}
		}
	}
	
	/**
	* Ersetz für das Countable-Interface
	*
	* @return int - Anzahl
	**/
	public function count() {
		return count($this->objects);
	}
	
	/**
	* Zählt die geladenen Objekte
	*
	* @return int - Anzahl
	**/
	public function countObjects() {
		return count($this->objects);
	}
	
	/**
	* Zählt alle vorhandenen Objekte
	*
	* @return int - Anzahl
	**/
	public function countAllObjects() {
		return $this->tableActions->count($this->getAllWhereString());
	}
	
	/**
	* Gibt alle Objekte zurück.
	*
	* @return array - Alle Objekte
	**/
	public function listObjects() {
		return $this->objects;
	}
	
	/**
	* Gibt es ein Objekt mit dieser ID?
	*
	* @param int $taskID - ID
	* @return bool - Ja/Nein
	**/
	public function existObjectForID($objectID) {
		return isset($this->objects[$objectID]);
	}
	
	/**
	* Gibt ein Objekt mit einer bestimmten ID zurück.
	*
	* @param int $objectID - Die ID.
	* @return object - Die Ausschreibung
	**/
	public function getObjectForID($objectID) {
		if(!$this->existObjectForID($objectID)) throw new \Exception('Ein Objekt mit dieser ID existiert nicht.', 1101);
		
		return $this->objects[$objectID];
	}
	
	/**
	* Fügt ein neues Objekt hinzu.
	*
	* @param object $task - Das neue Objekt
	**/
	public function addObject($object) {	
		$contentArray = $this->getContentArrayForObject($object);
		if($this->groupID !== false)
			$contentArray[static::GROUPID_FIELDNAME] = $this->groupID;
		
		$queryObject = $this->tableActions->insert($contentArray);
		$objectID = $queryObject->getLastID();
		
		$this->objects[$objectID] = $object;
		$this->unchangedObjects[$objectID] = clone $object;
	}
	
	/**
	* Löscht ein Objekt aus der Datenbank.
	*
	* @param int $objectID - ID
	**/
	public function removeObject($objectID) {
		$this->tableActions->delete(['id'=>$objectID]);
		
		unset($this->objects[$objectID]);
		unset($this->unchangedObjects[$objectID]);
	}
}