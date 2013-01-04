<?php
/**
*
* Verwaltet die Ausschreibungs-Modelle
* Datum: 30. November 2012
*
**/
namespace Game\Task;

class Model extends \Core\Data {
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
	* Gibt zurück, welche Stationen angefahren werden sollen.
	*
	* @return array[Station] - Anzufahrenden Stationen
	**/
	public function getStations() {
		$stationIDArray = $this->properties['stations'];
		$stationArray = array();
		
		// Stationen zu den IDs finden
		foreach($stationIDArray as $currentID)
			$stationArray[] = \Game\Station::getObjectForID($currentID);
		
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
		$stationArray = $this->getStations();
		
		$string = sprintf($string, $stationArray[0]->getName(), $stationArray[count($stationArray)-1]->getName());
	
		return $string;
	}
}
?>