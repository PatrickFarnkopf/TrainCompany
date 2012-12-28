<?php
/**
*
* Fahrt des Zuges.
* Datum: 19. Dezember 2012
*
**/
namespace Game\Task\Journey\Step;

class Travel extends \Game\Task\Journey\Step {
	/**
	* Gibt zurück, wie lange dieser Schritt braucht
	*
	* @return Time - Dauer
	**/
	public function getDurationTime() {
		// Die aktuelle Zugeinheit bekommen
		$trainUnit = $this->getTrainUnit();
		// Die Streckeneheit bekommen
		$pathUnit = $this->getPathUnit();
		// Den Fahrplan bekommen
		$taskSchedule = $this->getTaskSchedule();
		
		// Welche Stationen müssen angefahren werden
		$neededStations = $this->getNeededStations();
		// Welche Station wird als nächstes angefahren?
		$nextStation = $this->getNextStation();
		
		// Fahrzeit auf dieser Strecke berechen		
		$calcedTime = $pathUnit->calcTimeWithTrainUnit($trainUnit, \Game\Train\Unit::CURRENT_WEIGHT, $neededStations, false)[$nextStation->getID()];
		$scheduledTime = $taskSchedule->getTimesForStation($nextStation, false)['arrival'];
		
		// Berechnete Zeit länger als die im Fahrplan eingetragene Zeit
		if($calcedTime->toInt() > $scheduledTime->toInt()) {
			// Verspätung hinzufügen
			$delayTime = new \Core\Time($calcedTime->toInt() - $scheduledTime->toInt());
			$delayObject = new \Game\Task\Journey\Delay('Der erstellte Fahrplan konnte nicht komplett eingehalten werden.', $delayTime);
				
			$this->addDelay($delayObject);
			
			return $calcedTime;
		}
		
		return $scheduledTime;
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
}

?>