<?php
/**
*
* Gruppen für Zugeinheiten
* Datum: 4. November 2012
*
**/
namespace Game\Train\Unit;

class Group {
	private $name, $trainUnitIDs = [];
	
	/**
	* Eine neue Gruppe erstelen
	*
	* @param string $name - Name der Gruppe
	**/
	public function __construct($name) {
		self::validateName($name);
		
		$this->setName($name);
	}
	
	/**
	* Gibt den Namen der Gruppe zurück
	*
	* @param string $name - Name
	**/
	public function setName($name) {
		self::validateName($name);
	
		$this->name = $name;
	}
	
	/**
	* Gibt den Namen der Gruppe zurück
	*
	* @return string - Name
	**/
	public function getName() {
		return $this->name;
	}
	
	/**
	* Fügt einen neue Zugeinheit an das Ende der Gruppe hinzu
	*
	* @param int $trainUnitID - ID der Zugeinheit
	**/
	public function addToEnd($trainUnitID) {
		$this->trainUnitIDs[] = (int)$trainUnitID;
	}
	
	/**
	* Fügt eine Zugeinheit direkt hinter einer anderen in dieser Gruppe
	*
	* @param int $trainUnitID - ID der Zugeinheit
	* @param int $afterTrainUnitID - Nach dieser Zugeinheit
	**/
	public function addAfter($trainUnitID, $afterTrainUnitID) {
		if(!isset($this->trainUnitIDs[array_search($afterTrainUnitID,$this->trainUnitIDs)])) {
			$this->addToEnd($trainUnitID);
			return;
		}
		
		$newArray = [];
		foreach($this->trainUnitIDs as $currentTrainUnitID) {
			$newArray[] = $currentTrainUnitID;
			
			if($newArray[count($newArray)-1] == $afterTrainUnitID) $newArray[] = $trainUnitID;
		}
		$this->trainUnitIDs = $newArray;
	}
	
	/**
	* Löscht eine ID aus der Gruppe
	*
	* @param int $trainUnitID - ID der Zugeinheit
	**/
	public function del($trainUnitID) {
		$key = array_search($trainUnitID, $this->trainUnitIDs);
		unset($this->trainUnitIDs[$key]);
		$this->trainUnitIDs = array_values($this->trainUnitIDs);
	}
	
	/**
	* Gibt die IDs der Zugeinheiten zurück, die in dieser Gruppe sind.
	*
	* @return array - Array mit Zugeinheiten-IDs
	**/
	public function listIDs() {
		return $this->trainUnitIDs;
	}
	
	/**
	* Zählt die Zugeinheiten.
	*
	* @return int - Anzahl der Zugeinheiten
	**/
	public function countIDs() {
		return count($this->trainUnitIDs);
	}
	
	/**
	* Überprüft einen Gruppen-Namen auf validät
	*
	* @param string $groupName - Gruppen-Name
	**/
	public function validateName($groupName) {
		if(strlen($groupName) < 3)	
			throw new \HumanException('Der Gruppenname muss mindestens 3 Zeichen lang sein.', -1);
	}
}
?>