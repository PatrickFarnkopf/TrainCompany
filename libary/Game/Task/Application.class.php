<?php
/**
*
* Eine Aufgabe, die der User erledigigen muss.
* Datum: 2. Dezember 2012
*
**/
namespace Game\Task;

class Application {
	private $trainUnitID = -1;
	private $pathUnit, $taskSchedule;
	
	/**
	* Gibt das Ausschreiben zurück
	*
	* @return Task - Ausschreiben
	**/
	public function getTask() {
		return $this->task;
	}
	
	/**
	* Setzt die Zugeinheit
	*
	* @param int $trainUnitID - Zugeinheit-ID
	**/
	public function setTrainUnitID($trainUnitID) {
		$this->trainUnitID = $trainUnitID;
	}
	
	/**
	* Gibt die ID der Zugeinheit zurück
	*
	* @return int - ID der Zugeinheit
	**/
	public function getTrainUnitID() {
		return $this->trainUnitID;
	}
	
	/**
	* Holt die Zugeinheit, dem aktuellem User zugehörig.
	*
	* @param User $user - Der User
	* @return TrainUnit - Zugeinheit
	**/
	public function getTrainUnit(\Game\User $user) {
		$userTrainUnits = $user->listTrainUnits();
		if(!isset($userTrainUnits[$this->trainUnitID])) return false;
	
		return $userTrainUnits[$this->trainUnitID];
	}
	
	/**
	* Setzt die Strecke zu dieser Ausschreibung
	*
	* @param PathUnit $pathUnit - Streckenverbund
	**/
	public function setPathUnit(\Game\Path\Unit $pathUnit) {
		$this->pathUnit = $pathUnit;
	}
	
	/**
	* Gibt die Strecke zurück.
	*
	* @return PathUnit - Streckenverbund
	**/
	public function getPathUnit() {
		return $this->pathUnit;
	}
	
	/**
	* Setzt den Fahrplan
	*
	* @param TaskSchedule $taskSchedule
	**/
	public function setTaskSchedule(Schedule $taskSchedule) {
		$this->taskSchedule = $taskSchedule;
	}
	
	/**
	* Gibt den Fahrplan zurück
	*
	* @return TaskSchedule
	**/
	public function getTaskSchedule() {
		return $this->taskSchedule;
	}
	
	/**
	* Überprüft die Bewerbung auf Richtigkeit und gibt eventuell Fehler zurück.
	*
	* @param Task $task - Die Ausschreibung
	* @param User $user - Der User
	* @return bool - Wirft eine HumanException, wenn ein Fehler auftritt.
	**/
	public function checkTrainUnit(\Game\Task $task, \Game\User $user) {
		if(!$this->getTrainUnit($user) || !$task->isCompatibleTrainUnit($this->getTrainUnit($user)))
			throw new \HumanException('Die ausgewählte Zugeinheit ist nicht mit dieser Ausschreibung kompatibel.',-1);
		
		return true;
	}
	
	/**
	* Überprüft die Bewerbung auf Richtigkeit und gibt eventuell Fehler zurück.
	*
	* @param Task $task - Die Ausschreibung
	* @param User $user - Der User
	* @return bool - Wirft eine HumanException, wenn ein Fehler auftritt.
	**/
	public function checkPathUnit(\Game\Task $task, \Game\User $user) {
				if(!is_object($this->pathUnit) || !$task->getBestPathUnit([$this->pathUnit]))
			throw new \HumanException('Die ausgewählte Strecke ist nicht mit dieser Ausschreibung kompatibel.',-1);
		if(!$this->pathUnit->isEletrified() && $this->getTrainUnit($user)->getDrive() == \Game\Train::ELECTRO_DRIVE)
			throw new \HumanException('Die ausgewählte Zugeinheit kann nicht auf der ausgewählten Strecke fahren.',-2);
	}
}