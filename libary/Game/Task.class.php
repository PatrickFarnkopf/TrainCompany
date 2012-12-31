<?php
/**
*
* Eine Aufgabe, die der User erledigigen muss.
* Datum: 28. November 2012
*
**/
namespace Game;

class Task {
	const APPLICATION_TIME = 86400; // Ein Tag

	const NO_APPLICATION = 0;
	const WITH_APPLICATION = 1;

	private $title,$description,$plops,$type;
	private $neededCapacity = array();
	private $stations = array();
	private $applications = array();
	private $endTime = 0;
	
	/**
	* Erstellt neue Aufgabe, mit den Grund-Eigenschaften.
	*
	* @param string $title - Titel der Aufgabe
	* @param string $description - Beschreibung der Aufgabe
	* @param int $plops - Wie viel Geld gibt es für diese Aufgaben?
	* @param NO_APPLICATION/WITH_APPLICATION $type - Art der Aufgabe? [optional]
	**/
	public function __construct($title, $description, $plops, $type=0) {
		$this->title = $title;
		$this->description = $description;
		$this->plops = $plops;
		$this->type = $type;
	}
	
	/**
	* Gibt den Title der Aufgabe zurück
	*
	* @return string - Der Title
	**/
	public function getTitle() {
		return $this->title;
	}
	
	/**
	* Gibt die Beschreibung der Aufgabe zurück
	*
	* @return string - Die Beschreibung
	**/
	public function getDescription() {
		return $this->description;
	}
	
	/**
	* Gibt die Belohnung zurück.
	*
	* @return int - Belohnung in Plops
	**/
	public function getPlops() {
		return $this->plops;
	}
	
	/**
	* Setzt die das Bewerbungs-Array
	*
	* @param array $applications - Die Bewerbungen
	**/
	public function setApplications(array $applications) {
		$this->applications = $applications;
	}
	
	/**
	* Gibt die Bewerbungen als Array zurück.
	*
	* @return array - Die Bewerbungen
	**/
	public function getApplications() {
		return $this->applications;
	}
	
	/**
	* Fügt eine Bewerbung hinzu.
	*
	* @param TaskApplication $taskApplication - Die Bewerbung
	* @param User $user - Der User, der die hinzufügt.
	**/
	public function addApplication(\Game\Task\Application $taskApplication, User $user) {
		if($this->endTime == 0)
			$this->endTime = time() + self::APPLICATION_TIME;
	
		$this->applications[$user->getUserID()] = $taskApplication;
	}
	
	/**
	* Eine Bewerbung für diesen User vorhanden?
	*
	* @param User $user
	* @return bool
	**/
	public function existApplicationForUser(User $user) {
		return isset($this->applications[$user->getUserID()]);
	}
	
	/**
	* Zieht eine Bewerbung für einen Spieler zurück
	*
	* @param User $user
	**/
	public function revokeApplicationForUser(User $user) {
		unset($this->applications[$user->getUserID()]);
	}
	
	/**
	* Zählt die Bewerbungen
	*
	* @return int - Anzahl der Bewerbungen
	**/
	public function countApplications() {
		return count($this->applications);
	}
	
	/**
	* Zählt alle Bewerbungen, ohne den angegeben User
	*
	* @param User $user 
	* @return int - Anzahl der Bewerbungen
	**/
	public function countApplicationsWithoutUser(User $user) {
		$applications = $this->applications;
		unset($applications[$user->getUserID()]);
		
		return count($applications);
	}
	
	/**
	* Alle Bewerbungen löschen.
	**/
	public function removeAllApplications() {
		$this->applications = array();
	}
	
	/**
	* Gibt die beste Bewerbung und den User zurück
	*
	* @return array('application'=>Bewerbung,'user'=>Der User)
	**/
	public function getBestApplicationAndUser() {
		$capacities = array_keys($this->getNeededCapacity());
		
		$applications = $this->applications;
		$fullTimes = array();
		$fullCapacity = array();
		
		// Die Werte für alle Bewerbungen bekommen
		foreach($applications as $userID => $currentApplication) {
			$fullTimes[$userID] = $currentApplication->getTaskSchedule()->getFullTime()->toInt();
			$fullCapacity[$userID] = $currentApplication->getTrainUnit(i::User($userID))->getFullCapacity($capacities);
		}
		
		// Durch Sortieren die Plätze ermitteln
		asort($fullTimes);
		arsort($fullCapacity);
		
		// Array umdrehen (Anders rum ist es interessanter)
		$fullTimePlaces = array_flip(array_keys($fullTimes));
		
		// Array umdrehen (Anders rum ist es interessanter)
		$fullCapacityPlaces = array_flip(array_keys($fullCapacity));
			
		// Die Gesamt-Plätze der User ermitteln
		$places = array();
		foreach(array_keys($applications) as $userID) {
			$capacityPlace = $fullCapacityPlaces[$userID];
			$timePlace = $fullTimePlaces[$userID];
			
			$places[$userID] = ($capacityPlace+$timePlace) / 2;
		}
		
		// Die Plätze mal wieder sortieren
		asort($places);
		
		$bestUserID = array_keys($places)[0];
		$bestUser = i::User($bestUserID);
		
		$bestApplication = $applications[$bestUserID];
		
		return array('application'=>$bestApplication, 'user'=>$bestUser);
	}
	
	/**
	* Setzt Die Endzeit.
	*
	* @param int $endTime - Ende der Ausschreibungs-Phase
	**/
	public function setEndTime($endTime) {
		$this->endTime = $endTime;
	}
	
	/**
	* Gibt die Endzeit zurück
	*
	* @return int - Ende der Ausschreibungs-Phase
	**/
	public function getEndTime() {
		return $this->endTime;
	}
	
	/**
	* Gibt zurück wie viel Zeit noch bis zum Ende ist.
	*
	* @return Time - Zeit bis zum Ende der Ausschreibung.
	**/
	public function getTimeTillEndTime() {
		return new \Core\TimeDuration($this->endTime - time());
	}
	
	/**
	* Setzt die benötigiten Kapazitäten und wie viel davon. Falls die Anzahl unbekannt ist 0!
	*
	* @param array $neededCapacity - Benötigten Kapazitäten als Array mit ID.
	**/
	public function setNeededCapacity(array $neededCapacity) {
		$this->neededCapacity = $neededCapacity;
	}
	
	/**
	* Gibt die benötigten Kapazitäten zurück.
	*
	* @return array - Kapazitäten
	**/
	public function getNeededCapacity() {
		return $this->neededCapacity;
	}
	
	/**
	* Setzt die Bahnhöfe, an denen der Zug halten muss.
	*
	* @param array[Station] $stations - Bahnhofs-Objekte als Array
	**/
	public function setStations(array $stations) {
		$this->stations = $stations;
	}
	
	/**
	* Setzt die Bahnhöfe, an denen der Zug halten muss.
	*
	* @param array[int] $stationIDs - Bahnhof-IDs als Objekt
	**/
	public function setStationIDs(array $stationIDs) {
		$this->stations = array();
		foreach($stationIDs as $currentID)
			$this->stations[] = Station::getObjectForID($currentID);
	}
	
	/**
	* Gibt die Bahnhöfe zurück, an denen gehalten werden muss.
	*
	* @return array[Station] - Bahnhof-Objekte als Array
	**/
	public function getStations() {
		return $this->stations;
	}
	
	/**
	* Gibt den Typ der Aufgabe zurück. (Mit Bewerbung oder ohne)
	*
	* @return NO_APPLICATION/WITH_APPLICATION - Typ der Aufgabe
	**/
	public function getType() {
		return $this->type;
	}
	
	/**
	* Gibt zurück, ob die Zugeinheit mit der Ausschreibung „kompatibel“ ist.
	*
	* @param TrainUnit $trainUnit - Die Zugeinheit
	* @return bool - Kompatibel?
	**/
	public function isCompatibleTrainUnit(\Game\Train\Unit $trainUnit) {
		if($trainUnit->isLocked()) return false;
		if($trainUnit->getDrive() == Train::NO_DRIVE) return false;
	
		$trainUnitCapacity = $trainUnit->getCapacity();
		foreach($this->neededCapacity as $currentCapacity=>$value) {
			if(!isset($trainUnitCapacity[$currentCapacity]) || $trainUnitCapacity[$currentCapacity] < $value) return false;
		}
		
		return true;
	}
	
	/**
	* Gibt die beste PathUnit, aus den gegebenen, für die Ausschreibung zurück
	*
	* @param array[PathUnit] $pathUnits - Array mit Strecken-Verbünden
	* @return PathUnit
	**/
	public function getBestPathUnit(array $pathUnits) {
		$bestPathUnit = false;
		foreach($pathUnits as $currentPathUnit) {
			$paths = $currentPathUnit->listPaths();
			$stationNeeded = $this->getStations();
			
			// Bedingungen unter denen die Strecke nicht optimal ist!
			// Erstes Element hat den ersten Bahnhof der Ausschreibung weder als End- noch als Startbahnhof.
			if(($paths[0]->getStartStation() != $stationNeeded[0] && $paths[0]->getEndStation() != $stationNeeded[0])) continue;
			if(isset($paths[1])) {
				// Zweites Element hat den ersten Bahnhof der Ausschreibung entweder als End- oder als Startbahnhof.
				if($paths[1]->getStartStation() == $stationNeeded[0] || $paths[1]->getEndStation() == $stationNeeded[0]) continue;
			}
			// Letztes Element hat den letzten Bahnhof der Ausschreibung weder als End- noch als Startbahnhof.
			if($paths[count($paths)-1]->getStartStation() != $stationNeeded[count($stationNeeded)-1] &&
					$paths[count($paths)-1]->getEndStation() != $stationNeeded[count($stationNeeded)-1]) continue;
			if(isset($paths[count($paths)-2])) {
				// Vorletztes Elemtn hat den letzten Bahnhof der Ausschreibung entweder als End- oder als Startbahnhof.
				if($paths[count($paths)-2]->getStartStation() == $stationNeeded[count($stationNeeded)-1] ||
					$paths[count($paths)-2]->getEndStation() == $stationNeeded[count($stationNeeded)-1]) continue;
			}
			
			// Immer noch nicht weiter? Das muss ein guter Strecken-Verbund sein!
			$bestPathUnit = $currentPathUnit;
				
		}
		
		if($bestPathUnit === false)
			throw new \HumanException('Die Start-/Endbahnhöfe, die du ausgewählt hast, stimmen nicht mit denen der Ausschreibung überein.', -1);
		
		$pathUnitStations = $bestPathUnit->getStations();
		foreach($this->getStations() as $currentStation) {
			if(in_array($currentStation, $pathUnitStations)) continue;
			
			throw new \HumanException('Die ausgewählte Strecke fährt nicht alle benötigten Bahnhöfe an.', -2);
		}
		
		return $bestPathUnit;
	}
}
?>