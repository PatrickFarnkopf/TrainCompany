<?php
/**
*
* Verwaltet die Ausschreibungs-Modelle
* Datum: 30. November 2012
*
**/
namespace Game\Task;

class Model extends \Game\Data {
	use \Core\Data\Vars;
	
	private $direction = 0;
	
	/**
	* Gibt den Namen aus der Ausschreibung zurück
	*
	* @return string - Name
	**/
	public function getName() {
		$nameString = parent::getName();
		
		return $this->makeString($nameString);
	}
	
	/**
	* Eine Sammlung an Beschreibungen.
	*
	* @param array[String] $descriptions - Array mit mehreren Beschreibungen
	**/
	public function setDescriptions(array $descriptions) {
		$this->properties['descriptions'] = $descriptions;
	}
	
	/**
	* Gibt eine zufällige, der zur Verfügung stehendenen Beschreibungen zurück
	*
	* @return string - Eine Beschreibung
	**/
	public function getDescription() {
		$descriptionElement = mt_rand(0,count($this->properties['descriptions'])-1);
		$descriptionString = $this->properties['descriptions'][$descriptionElement];
		
		return $this->makeString($descriptionString);
	}
	
	/**
	* Setzt, wie viel Belohnung für diese Aufgaben gegeben wird.
	*
	* @params int $plops - Belohnung
	**/
	public function setPlops($plops) {
		if($plops < 10000) throw new \HumanException('Der Lohn muss mindestens 10.000 Plops betragen.', 2030);
	
		$this->properties['plops'] = $plops;
	}
	
	/**
	* Wie viel Prozent dieser Preis +- verändert werden soll
	*
	* @param int $plopDifferent - Angabe in %
	**/
	public function setPlopDifferent($plopDifferent) {
		if($plopDifferent < 0) throw new \HumanException('Die prozentuale Abweichung muss positiv sein.', 2032);
	
		$this->properties['plopDifferent'] = $plopDifferent;
	}
	
	/**
	* Gibt einen zufälligen Preis, der im definierten Rahmen liegt
	*
	* @return int - Preis
	**/
	public function getPlops() {
		$different = mt_rand(-$this->properties['plopDifferent'], $this->properties['plopDifferent']);
		
		$plops = $this->properties['plops'] / 1000;
		$plops += round($plops * ($different / 100),1);
		
		return $plops * 1000;
	}
	
	/**
	* Setzt die Station, die möglicherweiße angefahren werden sollen. (Die erste und die letzte Station werden IMMER angefahren.
	*
	* @param array[Station] $stations - Array mit Stationen
	**/
	public function setStations(array $stations) {
		if(count($stations) < 2) throw new \Exception('Es müssen mindestens zwei Stationen angefahren werden.', 2031);
	
		$this->properties['stations'] = $stations;
	}
	
	/**
	* Setzt die Stationen für die IDs.
	*
	* @param array[int] $stationIDs - Array mit Stationen-IDs
	**/
	public function setStationIDs(array $stationIDs) {
		if(count($stationIDs) < 2) throw new \Exception('Es müssen mindestens zwei Stationen angefahren werden.', 2031);
	
		$this->properties['stations'] = array();
		foreach($stationIDs as $currentID)
			$this->properties['stations'][] = \Game\Station::getObjectForID($currentID);
	}
	
	/**
	* Gibt zurück, welche Stationen angefahren werden sollen.
	*
	* @return array[Station] - Anzufahrenden Stationen
	**/
	public function getStations() {
		$stationArray = $this->properties['stations'];
		if($this->direction) {
			krsort($stationArray);
			$stationArray = array_values($stationArray);
		}
		
		do {
			$stations = array();
			$stations[] = $stationArray[0];
		
			for($i=1; $i<count($stationArray)-2; $i++) {
				 if(mt_rand(0,1)) $stations[] = $stationArray[$i];
			}
		
			$stations[] = $stationArray[count($stationArray)-1];
		// Mindestens 50% der Stationen sollten angefahren werden.
		} while(count($stations) < count($stationArray) / 2);
		
		return $stations;
	}
	
	/**
	* Setzt die Kapazität einer Ausschreibung
	*
	* @param array $neededCapacity - Benötigte Kapazität
	**/
	public function setNeededCapacity(array $neededCapacity) {
		$this->properties['neededCapacity'] = $neededCapacity;
	}
	
	/**
	* Setzt die Abweichung in Prozent
	*
	* @param int $different - Abweichung in Prozent
	**/
	public function setNeededCapacityDifferent($different) {
		$this->properties['neededCapacityDifferent'] = $different;
	}
	
	/**
	* Gibt die benötigten Kapazitäten zurück
	*
	* @return array - Kapazitäten
	**/
	public function getNeededCapacity() {
		$neededCapacity = array();
		foreach($this->properties['neededCapacity'] as $currentCapacity=>$value) {
			$different = mt_rand(-$this->properties['neededCapacityDifferent'], $this->properties['neededCapacityDifferent']);		
			$value *= $different / 100;
	
			$neededCapacity[$currentCapacity] = $value;
		}
		
		return $neededCapacity;
	}
	
	/**
	* Ändert die Richtung der Fahrt
	**/
	public function swapDirection() {
		$this->direction = mt_rand(0,1);
	}
	
	/**
	* Fügt Start- und Endbahnhof in einen String.
	*
	* @param string $string - Der String
	* @return string - String mit Start- und Endbahnhof
	**/
	private function makeString($string) {
		$stationArray = $this->properties['stations'];
		if($this->direction) {
			krsort($stationArray);
			$stationArray = array_values($stationArray);
		} 
		
		$string = sprintf($string, $stationArray[0]->getName(), $stationArray[count($stationArray)-1]->getName());
	
		return $string;
	}
}
?>