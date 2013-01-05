<?php
/**
*
* Die Klasse verwaltet den Benutzer, lässt eine Regestrierung und eine Löschung eines Users zu.
* Datum: 27. Juni 2012
*
**/
namespace Game;

class User extends \Core\User {
	const START_PLOPS = 500000;

	protected $plops;
	protected $trainUnits;
	protected $trainUnitGroups;

	/**
	* Öffnet eine neue User-Klasse mithilfe der userID.
	*
	* @param int $userID - User-ID
	**/
	public function __construct($userID) {
		parent::__construct($userID);
		
		$this->plops = $this->dataArray['plops'];
		$this->trainUnits = unserialize($this->dataArray['trainUnits']); 
		$this->trainUnitGroups = unserialize($this->dataArray['trainUnitGroups']);
		
		if(!is_array($this->trainUnits)) $this->trainUnits = [];
		if(!is_array($this->trainUnitGroups)) {
			$this->trainUnitGroups = [];
			$this->addTrainUnitGroup(new Train\Unit\Group('Ungruppierte Züge'));
			$this->addTrainUnitGroup(new Train\Unit\Group('Regionalverkehr'));
			$this->addTrainUnitGroup(new Train\Unit\Group('Fernverkehr'));
			$this->addTrainUnitGroup(new Train\Unit\Group('Güterverkehr'));
		}
	}
	
	public function __destruct() {
		$this->saveInDB['plops'] = $this->plops;
		$this->saveInDB['trainUnits'] = serialize($this->trainUnits);
		$this->saveInDB['trainUnitGroups'] = serialize($this->trainUnitGroups);
		
		parent::__destruct();
	}
	
	/**
	* Fügt dem User neue Plops hinzu.
	*
	* @param int $plops - Anzahl der hinzuzufügenden Plops
	**/
	public function addPlops($plops) {
		$this->plops += $plops;
	}
	
	/**
	* Nimmt dem User Plops.
	*
	* @param int $plops - Anzahl der abzuziehenden Plops
	**/
	public function subPlops($plops) {
		$this->plops -= $plops;
	}
	
	/**
	* Gibt die aktuelle Anzahl an Plops zurück
	*
	* @return int - Plops
	**/
	public function getPlops() {
		return $this->plops;
	}
	
	/**
	* Löscht eine Zugeinheit, mit passender ID
	*
	* @param int $id - Die ID der Zug-Einheit.
	**/
	public function removeTrainUnit($id) {
		unset($this->trainUnits[$id]);
	}
	
	/**
	* Fügt eine Zugeinheit dem User hinzu.
	*
	* @param \Game\Train\Unit $trainUnit - Zugeinheit
	* @return int - ID der Zugeinheit
	**/
	public function addTrainUnit(\Game\Train\Unit $trainUnit) {
		$this->trainUnits[] = $trainUnit;
		return max(array_keys($this->trainUnits));
	}
	
	/**
	* Gibt eine Liste mit allen Zugeinheit zurück.
	*
	* @param int $groupID - ID der Gruppe, von der aussschließlich die Züge angezeigt werden sollen. [optional]
	* @return array - Array mit Zugeinheiten
	**/
	public function listTrainUnits($groupID=false) {
		if ($groupID === false) return $this->trainUnits;
			
		$trainUnitIDs = $this->trainUnitGroups[$groupID]->listIDs();
		$trainUnits = [];
		foreach($trainUnitIDs as $currentID) $trainUnits[$currentID] = $this->trainUnits[$currentID];
		
		return $trainUnits;
	}
	
	/**
	* Zählt die Zugeinheiten
	*
	* @param int $groupID - ID der Gruppe, von der aussschließlich die Züge gezählt werden sollen. [optional]
	* @return int - Anzahl der Zugeinheiten
	**/
	public function countTrainUnits($groupID=false) {
		return count($this->listTrainUnits($groupID));
	}
	
	/**
	* Fügt eine neue Zugeinheiten-Gruppe dem User hinzu
	*
	* @param \Game\Train\Unit\Group $trainUnitGroup - Eine neue Zugeinheitengruppe
	**/
	public function addTrainUnitGroup(\Game\Train\Unit\Group $trainUnitGroup) {
		$this->trainUnitGroups[] = $trainUnitGroup;
	}
	
	/**
	* Löscht eine Zuggruppe.
	*
	* @param int $trainUnitGroupID - Die ID
	**/
	public function removeTrainUnitGroup($trainUnitGroupID) {
		unset($this->trainUnitGroups[$trainUnitGroupID]);
	}
	
	/**
	* Gibt die Zugeinheiten-Gruppen des Users zurück
	*
	* @return array[TrainUnitGroup] - Array mit Zugeinheiten
	**/
	public function listTrainUnitGroups() {
		return $this->trainUnitGroups;
	}
	
	/**
	* Gibt das Durchschnitssalter aller Zugeinheiten eines Spieler zurück
	*
	* @return float - Durchschnitssalter in Spieljahren
	**/
	public function getAverageAgeOfTrainsUnits() {
		if(count($this->trainUnits) == 0) return 0;
		
		$ages = 0;
		foreach($this->trainUnits as $currentTrainUnit) $ages += $currentTrainUnit->getAverageAge();
		
		return $ages / count($this->trainUnits);
	}
	
	/**
	* Gibt den Gesamtwert des Fuhrparks zurück.
	*
	* @return int - Gesamtwert
	**/
	public function getSellPriceOfTrainsUnits() {
		$price = 0;
		foreach($this->trainUnits as $currentTrainUnit) $price += $currentTrainUnit->getSellPrice();
		
		return $price;
	}
	
	/**
	* Zählt, wie oft der Benutzer einen bestimmten Zug hat
	*
	* @param Train $train - Der gesuchte Zug
	* @return int - Anzahl der Vorkommen
	**/
	public function searchTrain(Train $train) {
		$count = 0;
		foreach($this->trainUnits as $currentTrainUnit) $count += $currentTrainUnit->searchTrain($train);
		
		return $count;
	} 
	
	/**
	* Erstellt einen neuen Nutzer
	*
	* @param String $name - Der Nutzer-Name des Nutzers
	* @param String $firstPass - Passwort
	* @param String $secondPass - Passwort-Wiederholung
	* @param String $mail - Die Mail des Nutzers
	* @param array $moreInformations - Mehr Dinge, die geschrieben werden müssen.
	* @return User - Die User-Klasse des neuen Nutzers
	**/
	public static function createNewUser($name, $firstPass, $secondPass, $mail, array $moreInformations = []) {
		$moreInformations = ['plops'=>static::START_PLOPS] + $moreInformations;
		
		return parent::createNewUser($name, $firstPass, $secondPass, $mail, $moreInformations);
	}
}
?>