<?php
/**
*
* Der Fahrplan eines Zuges.
* Datum: 7. Dezember 2012
*
**/
namespace Game\Task;

class Schedule {
	private $stations = [], $arrivals = [], $departures = [];
	
	/**
	* Fügt eine neue Station mit Ankunft und Abfahrt hinzu.
	*
	* @param Station $station - Bahnhof, der angefahren wird.
	* @param Time $arrivalTime - Ankunfzeit in Sekunden
	* @param Time $departureTime - Abfahrtszeit in Sekunden
	**/
	public function addStation(\Game\Station $station, \Core\TimeDuration $arrivalTime, \Core\TimeDuration $departureTime) {
		if(in_array($station, $this->stations))
			throw new \Exception('Der Bahnhof „'.$station->getName().'“ ist bereits in diesem Fahrplan vorhanden', 2041);
	
		$this->stations[] = $station;
		
		$key = array_search($station, $this->stations);
		$this->arrivals[$key] = $arrivalTime;
		$this->departures[$key] = $departureTime;
	}
	
	/**
	* Gibt alle Stationen mit Halt zurück.
	*
	* @return array[Station]
	**/
	public function listStations() {
		return $this->stations;
	}
	
	/**
	* Gibt den letzten Halt im Fahrplan aus.
	*
	* @return Station
	**/
	public function getLastStation() {
		return $this->stations[count($this->stations)-1];
	}
	
	/**
	* Gibt die gesamte Zeitdauer zurück.
	*
	* @return Time
	**/
	public function getFullTime() {
		$lastElement = count($this->arrivals)-1;
		return $this->arrivals[$lastElement];
	}
	
	/**
	* Gibt die Zeiten für eine Station zurück
	*
	* @param Station $station
	* @param bool $showFullTime - Volle Zeiten oder einzelne Reisezeiten? [optional]
	* @return array('arrival'=> Ankunfzeit, 'depature'=>Abfahrtszeit)
	**/
	public function getTimesForStation(\Game\Station $station, $showFullTime = true) {
		if(!$this->existTimesForStation($station))
			throw new \Exception('Zu dem Bahnhof „'.$station->getName().'“ existieren keine Zeiten.', 2040);
		
		$key = array_search($station, $this->stations);
		
		$arrivalTime = $this->arrivals[$key];
		$departureTime = $this->departures[$key];
		
		// Wir wollen nicht die vollen Zeiten?
		if(!$showFullTime && $key > 0) {
			$lastKey = $key-1;
			
			$arrivalTime -= $this->arrivals[$lastKey];
			$departureTime -= $this->departures[$lastKey];
		}
		
		return ['arrival'=>$arrivalTime,'departure'=>$departureTime];
	}
	
	/**
	* Gibt zurück, ob Zeiten für einen Bahnhof existieren.
	*
	* @param Station $station
	* @return bool - Ja?/Nein?
	**/
	public function existTimesForStation(\Game\Station $station) {
		if (array_search($station, $this->stations) === false) return false;
		return true;
	}
	
	/**
	* Überprüft den Fahrplan auf fehlerhafte Einträge
	*
	* @return bool - True, wenn alles okay ist, sonst eine Exception
	**/
	public function check() {
		$lastTime = -1;
		foreach($this->listStations() as $currentStation) {
			$times = $this->getTimesForStation($currentStation);
			if($times['arrival']->toInt() <= $lastTime)
				throw new \HumanException('Der Zug kann nicht zu der selben oder einer früheren Zeit am Bahnhof „'.$currentStation->getName().'“ ankommen, wie er am vorherigen Bahnhof abgefahren ist.', -1);
			else if($times['arrival']->toInt() > $times['departure']->toInt() && $currentStation != $this->getLastStation())
				throw new \HumanException('Der Zug kann am Bahnhof „'.$currentStation->getName().'“ nicht abfahren, bevor er angekommen ist.', -2);
				
			$lastTime = $times['departure']->toInt();
		}
		
		return true;
	}
} 
?>