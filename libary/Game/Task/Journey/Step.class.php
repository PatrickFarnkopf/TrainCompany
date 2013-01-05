<?php
/**
*
* Ein Schritt einer Reise auf dem Schienennetz
* Datum: 19. Dezember 2012
*
**/
namespace Game\Task\Journey;

abstract class Step {
	protected $currentStation, $user, $task, $taskApplication, $delays = [];
	
	/**
	* Gibt den aktuellen Bahnhof zurück
	*
	* @return Station - Der aktuelle Banhof
	**/
	protected function getCurrentStation() {
		return $this->currentStation;
	}
	
	/**
	* Gibt die Bahnhöfe zurück, die auf der Strecke liegen
	*
	* @return array[Station] - Array mit allen Stationen
	**/
	protected function getStations() {
		return $this->taskApplication->getPathUnit()->getStations();
	}
	
	/**
	* Gibt die Bahnhöfe zurück, die angefahren werden müssen.
	*
	* @return array[Station] - Array mit allen Fahrplan-Halten
	**/
	protected function getNeededStations() {
		return $this->taskApplication->getTaskSchedule()->listStations();
	}
		
	/**
	* Gibt die Zugeinheit für diese Reise zurück.
	*
	* @return TrainUnit - Die Zugeinheit
	**/
	protected function getTrainUnit() {
		return $this->taskApplication->getTrainUnit($this->user);
	}
	
	/**
	* Gibt die zu befahrende Strecken-Einheit zurück
	*
	* @return PathUnit - Die Streckeneheit
	**/
	protected function getPathUnit() {
		return $this->taskApplication->getPathUnit();
	}

	/**
	* Gibt den Fahrplan zurück
	*
	* @return TaskSchedule - Der Fahrplan
	**/
	protected function getTaskSchedule() {
		return $this->taskApplication->getTaskSchedule();
	}
	
	/**
	* Fügt eine neue Verspätung hinzu.
	*
	* @param TaskJourneyDelay $delay - Neue Verspätung
	**/
	protected function addDelay(Delay $delay) {
		$this->delays[] = $delay;
	}
	

	/**
	* Erstellt den Reise-Schritt
	*
	* @param Station $currentStation - Die aktuelle Station
	* @param GameUser $user - Welcher Benutzer führt diesen Schritt durch?
	* @param Task $task - Die Ausschreibung
	* @param TaskApplication $taskApplication - Die Bewerbung
	**/
	public function __construct(\Game\Station $currentStation, \Game\User $user, \Game\Task $task, \Game\Task\Application $taskApplication) {
		$this->currentStation = $currentStation;
		$this->user = $user;
		$this->task = $task;
		$this->taskApplication = $taskApplication;
	}
	
	/**
	* Gibt zurück, wie viel Verspätung der Zug insgesammt schon hat
	*
	* @return array[TaskJourneyDelay] - Array mit allen Verspätungen
	**/
	public function getDelays() {
		return $this->delays;
	}

	/**
	* Gibt zurück, wie lange dieser Schritt braucht
	*
	* @return Time - Dauer
	**/
	abstract public function getDurationTime();
	
	/**
	* Gibt die nächste Station zurück.
	*
	* @return Station - Die nächste Station
	**/
	abstract public function getNextStation();
}

?>