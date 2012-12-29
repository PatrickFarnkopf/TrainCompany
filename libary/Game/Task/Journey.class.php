<?php
/**
*
* Eine Fahrt mit einem Zug auf dem Schienennetz.
* Datum: 13. November 2012
*
**/
namespace Game\Task;

class Journey {
	private $userID, $user;
	private $task, $taskApplication;
	private $startTime, $nextStepTime, $currentStep;
	private $delays = array();
	
	/**
	* Nimmt die Ausschreibung und die Bewerbung zu der Ausschreibung an.
	*
	* @param GameUser $user - Der User, der diese Ausschreibung ausführt
	* @param Task $task - Die Ausschreibung
	* @param TaskApplication $taskApplication - Die Bewerbung zu der Ausschriebung
	**/
	public function __construct(\Game\User $user, \Game\Task $task, Application $taskApplication) {
		$this->user = $user;
		$this->userID = $user->getUserID();
	
		$this->task = $task;
		$this->taskApplication = $taskApplication;
		
		$this->startTime = time();
		
		// Erste Station als aktuelle Station setzen.
		$this->runNextStep();
	}
	
	/**
	* Was soll alles mit eingeschläfert werden?
	*
	* @return array
	**/
	public function __sleep() {
		return array('userID', 'task', 'taskApplication', 'startTime', 'nextStepTime', 'currentStep', 'delays');
	}

	/**
	* Stellt das User-Objekt wieder her.
	**/
	public function __wakeup() {
		$this->user = \Game\i::User($this->userID);
	}
	
	/**
	* Gibt die Ausschreibung zurück
	*
	* @return Task
	**/
	public function getTask() {
		return $this->task;
	}
	
	/**
	* Fügt eine neue Verspätung hinzu.
	*
	* @param TaskJourneyDelay $delay - Neue Verspätung
	**/
	private function addDelay(\Game\Task\Journey\Delay $delay) {
		$this->delays[] = $delay;
		
		// Notification senden!
		$notification = new \Game\Notification('Verspätungs-Alarm!', 'Während der Ausschreibung „'.$this->task->getTitle().'“ hat eine Verspätung bekommen.',0,0,$delay);
		$this->user->addNotification($notification);
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
	* Gibt die Gesamt-Verspätung zurück
	*
	* @return Time
	**/
	public function getFullDelay() {
		$timeInt = 0;
		foreach($this->getDelays() as $currentDelay)
			$timeInt += $currentDelay->getTime()->toInt();
			
		return new \Core\TimeDuration($timeInt);
	}
	
	/**
	* Gibt zurück, wie viel Geld von dem Ausschreibungs-Erlös aufgrund der Verspätungen abgezogen wird.
	*
	* @return int
	**/
	public function getDelaySub() {
		// Wie lange braucht der Zug laut Fahrplan auf der Strecke
		$scheduledTime = $this->taskApplication->getTaskSchedule()->getFullTime();
		// Wie viel Verspätung hat der Zug?
		$delayTime = $this->getFullDelay();
		
		// Plop-Faktor ausrechnen 100% = Halbe Fahrplanzeit / Halbe Fahrplanzeit
		$delayFactor = $delayTime->toInt() / ($scheduledTime->toInt() / 2);
		
		// Verdienst durch die Ausschreibung
		$plopsAdd = $this->task->getPlops();
		// Abgezogene Plops
		$plopsSub = $plopsAdd * $delayFactor;
		
		// Auf Hunderter runden
		$plopsSub = round($plopsSub / 100) * 100;
		
		return $plopsSub;
	}
	
	/**
	* Gibt zurück, wie viel Verspätung der Zug aktuell hat.
	*	Das Ergebnis ist eine Hochrechnung.
	*
	* @return TimeDuration
	**/
	public function getCurrentDelay() {
		// Keine Ahnung?
	
		return new \Core\TimeDuration(0);
	}
	
	/**
	* Gibt zurück, wie viel Geld am Ende übrig bleibt.
	*
	* @return int
	**/
	public function getPlops() {
		$taskPlops = $this->task->getPlops();
		$subPlops = $this->getDelaySub();
		
		return $taskPlops - $subPlops;
	}
	
	/**
	* Gibt die vorraussichtliche Unix-Zeit am Ende der Ausschreibung zurück
	*
	* @return int
	**/
	public function getTimeAtEnd() {
		// Fahrplanankunft an der letzten Station
		$lastStationTimes = $this->taskApplication->getTaskSchedule()->getTimesForStation($this->getLastStation());
		$arrivalTime = $lastStationTimes['arrival'];
		
		// Verspätung bekommen
		$delayTime = $this->getCurrentDelay();
		
		// Ankunft mit Verspätung
		$arrivalTimeWithDelay = new \Core\TimeDuration($arrivalTime->toInt() + $delayTime->toInt());
		
		return $this->startTime + $arrivalTimeWithDelay->toInt();
	}
	
	/**
	* Gibt die aktuelle Zeit zurück.
	*
	* @return Time
	**/
	public function getCurrentTime() {
		return new \Core\TimeDuration(time() - $this->startTime);
	}
		
	/**
	* Gibt den aktuellen Bahnhof zurück.
	*
	* @return Station
	**/
	public function getCurrentStation() {
		return $this->currentStation;
	}
	
	/**
	* Gibt den nächsten Bahnhof zurück.
	*
	* @return Station
	**/
	public function getNextStation() {
		$stations = $this->getStations();
		
		$currentStepID = array_search($this->getCurrentStation(), $stations);
		$nextStepID = $currentStepID+1;
		
		return $stations[$nextStepID];
	}
	
		/**
	* Gibt die letzte Station der Reise zurück
	*
	* @return Station - Letzte Station
	**/
	public function getLastStation() {
		$stations = $this->getStations();
		$lastElement = count($stations)-1;
		
		return $stations[$lastElement];
	}
	
	/**
	* Gibt den zuletzte angefahrenen Bahnhof zurück.
	*
	* @return Station
	**/
	public function getLastNeededStation() {
		$stations = $this->getStations();
		$neededStations = $this->getNeededStations();
		
		// Die Stationen rückwärts durchgehen
		krsort($stations);
		
		$afterCurrentStation = false;
		foreach($stations as $currentStation) {
			if(!$afterCurrentStation && $currentStation != $this->getCurrentStation()) continue;
			$afterCurrentStation = true;
			
			// Die aktuelle Station muss angefahren werden? Super!
			if(in_array($currentStation, $neededStations))
				return $currentStation;
		}
		
		// Keine Station gefunden? Das geht doch gar nicht!
		throw new \HumanException('Im Fahrplan existiert kein Fahrplan-Halt vor dem aktuellen. Das darf nicht sein!', 2061);
	}
	
	/**
	* Setzt die Zeit bis zur nächsten Aktion
	*
	* @param Time $time - Nächste Aktion?
	**/
	private function setNextStepTime(Time $time) {
		$this->nextStepTime = $this->startTime + $time->toInt();
	} 
	
	/**
	* Gibt die Zeit bis zum nächsten Schritt zurück
	*
	* @return int
	**/
	public function getNextStepTime() {
		return $this->nextStepTime;
	}
	
	/**
	* Gibt die Rest-Zeit bis zum nächsten Schritt zurück
	*
	* @return Time
	**/
	public function getNextStepTimeDuration() {
		return new \Core\TimeDuration($this->nextStepTime - $this->startTime);
	}
	
	/**
	* Setzt die nächste Station
	**/
	private function setNextStation() {
		if(!is_object($this->currentStation))
			$this->currentStation = $this->getStations()[0];
		else
			$this->currentStation = $this->getNextStation();
	}
	
	/**
	* Existiert ein nächster Schritt?
	*
	* @return bool
	**/
	public function existNextStep() {
		// Alle Stationen die angefahren werden müssen.
		$stations = $this->taskApplication->getPathUnit()->getStations();
		
		return array_search($this->currentStation, $stations)+1 < count($stations)-1;
	}
	
	/**
	* Überprüft, ob der nächste Schritt verzögert ausgeführt wurde
	**/
	private function checkForDaemonDelay() {
		// Verzögerungen im Betriebsablauf? (Die Aufgabe wurde nicht rechtzeitig ausgeführt. Mindestens 60 Sekunden verzug.)
		if($this->getNextStepTime() != 0 && $this->getNextStepTime()+60 < time()) {
			$delayTime = new \Core\TimeDuration(time() - $this->getNextStepTime());
			$delayObject = new \Game\Task\Journey\Delay('Verzögerungen im Betriebsablauf.', $delayTime);
				
			$this->addDelay($delayObject);
		}
	}
}
?>