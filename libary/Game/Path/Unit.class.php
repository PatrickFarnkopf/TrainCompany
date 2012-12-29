<?php
/**
*
* Fasst mehrere Strecken zu einer langen Strecke zusammen
* Datum: 27. November 2012
*
**/
namespace Game\Path;

class Unit {
	private $paths, $startStation;

	/**
	* Speichert die Strecken die befahren werden.
	*
	* @param array[Path] $paths - Strecken (In richtiger Reihenfolge bitte!)
	* @param Station $startStation - Die Station, mit der die Strecke anfängt.
	**/
	public function __construct(array $paths, \Game\Station $startStation) {
		$this->paths = $paths;
		$this->startStation = $startStation;
	}
	
	/**
	* Gibt die einzelnen Strecken-Abschnitte zurück.
	*
	* @return array[Path]
	**/
	public function listPaths() {
		return $this->paths;
	}

	/**
	* Gibt zurück, ob der Strecken-Verbund durchgänig elektrifiziert ist
	*
	* @return bool - Elektrifiziert?
	**/
	public function isEletrified() {
		foreach($this->paths as $currentPath) {
			if(!$currentPath->isEletrified()) return false;
		}
		
		return true;
	}

	/**
	* Gibt zurück, welche Stationen ausgewählt wurden.
	*
	* @return array - Ausgewählte Stationen
	**/
	public function getStations() {
		$paths = $this->listPaths();
		
		$stationArray = array();
		$stationArray[] = $this->startStation;
		foreach($paths as $currentPath) {
			if($stationArray[count($stationArray)-1] != $currentPath->getStartStation())
				$stationArray[] = $currentPath->getStartStation();
			else
				$stationArray[] = $currentPath->getEndStation();
		}
	
		return $stationArray;
	}
	
	/**
	* Berechnet die Zeit, die gegebene Zugeinheit auf dem Streckenverbund braucht.
	*
	* @param TrainUnit $trainUnit - Zugeinheit
	* @param int $weightType - Leergewicht, aktuelles Gewicht oder max Gewicht?
	* @param array $stations - Stationen an denen gehalten werden soll.
	* @param bool $showFullTime - Volle Zeiten oder einzelne Reisezeiten? [optional]
	* @return array - Ankunfszeiten
	**/
	public function calcTimeWithTrainUnit(\Game\Train\Unit $trainUnit, $weightType, array $stations, $showFullTime = true) {
		$stations = $this->getStations();
		$arrivalTimes = array();
		
		$currentSpeed = 0;
		$fullTime = 0;
		
		for($i=0;$i<count($this->paths);$i++) {
			$nextStation = $stations[$i+1];
			if(isset($this->paths[$i+1]) && !in_array($nextStation, $stations))
				$nextSpeed = $this->paths[$i+1]->getMaxSpeed();
			else $nextSpeed = 0;
			
			$calculation = $this->paths[$i]->calcTimeWithTrainUnit($trainUnit, $weightType, $currentSpeed, $nextSpeed);
			
			$currentSpeed = $calculation['reachedSpeed'];
			$fullTime += $calculation['time']->toInt();
			$arrivalTimes[$nextStation->getID()] = $showFullTime ? new \Core\TimeDuration($fullTime) : $calculation['time'];
		}
		
		return $arrivalTimes;
	}
	
	/**
	* Gibt die Strecken-Einheit von einem Bahnhof zum nächsten zurück
	*
	* @param Station $startStation - Start-Bahnhof
	* @param Station $endStation - End-Bahnhof
	* @return PathUnit - Die neue Streckeneinheit
	**/
	public function getPathUnit(\Game\Station $startStation, \Game\Station $endStation) {
		$stations = array();
		$afterStart = false;
		
		foreach($this->getStations() as $currentStation) {
			if(!$afterStart && $startStation != $currentStation) continue;
			
			$stations[] = $currentStation;
			
			$afterStart = true;
			if($currentStation == $endStation) break;
		}
		
		try {
			$pathUnits = self::getPathUnitsToConnectStations($stations);
			$pathUnit = null;
		
			foreach($pathUnits as $currentPathUnit) {
				if($currentPathUnit->getStations()[0] == $startStation)
					$pathUnit = $currentPathUnit;
			}
		
			return $pathUnit;
		} catch(\HumanException $exception) {
			throw new \Exception('Die PathUnit konnte nicht gebildet werden.', 2070, $exception);
		}
	}
	
	/**
	* Erstellt aus einem Array an Stationen einen oder mehrere Strecken-Verbund, der alle Bahnhöfe abdeckt.
	*	Sollte die Strecke aus irgendeinem Grund nicht gebildet werden können, wird eine HumanException geworfen.
	*
	* @param array[Station] $stations - Die Stationen die „überfahren“ werden sollen.
	* @return array[PathUnit] - Array mit einer variablen Anzahl von Strecken-Verbünden
	**/
	public static function getPathUnitsToConnectStations(array $stations) {
		// Alle Strecke, die die ausgewählten Bahnhöfe verbinden in ein Array speichern
		$paths = array();
		foreach($stations as $currentStations) {
			foreach($stations as $secondStations) {
				if(!\Game\Path::existPathFromStationToStation($currentStations,$secondStations)) continue;
				if(!isset($paths[$currentStations->getID()])) $paths[$currentStations->getID()] = array();
				
				$paths[$currentStations->getID()][$secondStations->getID()] = \Game\Path::getPathFromStationToStation($currentStations,$secondStations);
			}
		}
		
		// Herausfinden, wo Strecken-Verbünde anfangen
		$startStationIDs = array();
		foreach($paths as $stationID => $currentStartStation) {
			// Es geht nur eine Strecke von diesem Bahnhof weg? Der Bahnhof muss ein Ende sein.
			if(count($currentStartStation) == 1) $startStationIDs[] = $stationID;
		}
		
		// Es muss eine gerade Anzahl an „Start-Bahnhöfen“ geben. Wenn nicht: Abbrechen!
		if(count($startStationIDs) % 2 != 0)
			throw new \HumanException('Es konnte keine durchgehende Strecke ermittelt werden. Die Strecken dürfen nicht verzweigt sein!', -1);
		
		// Die Strecken von einem Start-Bahnhof aus abbilden
		$pathUnits = array();
		foreach($startStationIDs as $currentStartID) {
			$currentStationID = $currentStartID;
			$lastStationID = -1;
			$currentPathUnit = array();		
			while(true) {
				// Stationen die vom aktuellen Bahnhof aus abgehen.
				$currenStationPaths = $paths[$currentStationID];
				foreach($currenStationPaths as $endStationID=>$path) {
					// Zurückführende Strecke? Ignorieren!
					if ($lastStationID == $endStationID) continue;
					
					// Neue letzte Station speichern
					$lastStationID = $currentStationID;
					$currentStationID = $endStationID;
					
					// Die weiterführende Strecke dem PathUnit-Array hinzufügen
					$currentPathUnit[] = $path;
					// Strecke aus dem Haupt-Array löschen
					unset($paths[$currentStationID][$endStationID]);

					// Wir wollen nur eine weiterführende Strecke haben.
					if (in_array($endStationID, $startStationIDs))
						break 2;
					else
						break;
				}		
			}
			
			$pathUnits[] = new self($currentPathUnit, \Game\Station::getObjectForID($currentStartID));
		}
		
		if(count($pathUnits) == 0)
			throw new \HumanException('Es konnte keine Verbindung zwischen den ausgewählten Bahnhöfen gebildet werden.', -2);
	
		return $pathUnits;
	}
}
?>