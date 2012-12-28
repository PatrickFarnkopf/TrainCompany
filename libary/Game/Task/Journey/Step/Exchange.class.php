<?php
/**
*
* Ein-/Umsteig bzw. das Be-/Entladen des Zuges
* Datum: 19. Dezember 2012
*
**/
namespace Game\Task\Journey\Step;

class Exchange extends \Game\Task\Journey\Step {
	/**
	* Führen einen Austausch der Waren durch
	*
	* @param Station $currenStation - Die aktuelle Station
	* @return Time - Verspätung, die durch den Ausstausch statt findet.
	**/
	private function exchangeCapacity() {
		// Aktuelle Station
		$currentStation = $this->getCurrentStation();
	
		// Ausstausch-Zeit
		$exchangeTimeInt = 0;
	
		// Zugeinheit/Informationen bekommen
		$trainUnit = $this->getTrainUnit();
		$capacityArray = $trainUnit->getCapacity();
		$usedCapacityArray = $trainUnit->getUsedCapacity();
		
		// Alle benötigten Kapazitäten der Ausschreibung durchgehen
		foreach($this->task->getNeededCapacity() as $currentCapacity => $value) {
			// Wie viel dieser Kapazität ist bereits benutzt?
			$usedCapacity = isset($usedCapacityArray[$currentCapacity]) ? $capacityArray[$currentCapacity] : 0;
			// Wie viel Kapatität kann noch genutzt werden?
			$toUseCapacity = (isset($capacityArray[$currentCapacity]) ? $capacityArray[$currentCapacity] : 0) - $usedCapacity;
		
			// Es ist von Anfang an definiert, wie viel Kapazität benötigt wird
			if($value > 0) {
				// Wie viel der Kapazität soll frei gemacht werden.
				$freeCapacity = $value;
				$useCapacity = $value;
			} else {
				// Werte aus der Station bekommen
				$freeCapacity = $currentStation->getExchangePassenger();
				$useCapacity = $currentStation->getExchangePassenger();
			}
			
			// Es kann nicht mehr entladen werden, wie drinnen ist.
			if($freeCapacity > $usedCapacity) $freeCapacity = $usedCapacity;
			// Das was freigeben wird kann natürlich auch mehr genutzt werden
			$toUseCapacity += $freeCapacity;
			
			// Der Zug ist zu klein?
			if($useCapacity > $toUseCapacity) {
				// Zufällige Verspätung hinzufügen
				$exchangeTimeInt += mt_rand(100,400);
				// Nicht mehr nutzen, als geht.
				$useCapacity = $toUseCapacity;
			}
			
			// Die Kapazität auch wirklich freigeben und nutzen
			$trainUnit->freeCapacity(array($currentCapacity=>$freeCapacity));
			$trainUnit->useCapacity(array($currentCapacity=>$useCapacity));
		}
		
		// In ein Time-Objekt umwandeln
		$exchangeTime = new \Core\Time($exchangeTimeInt);
		
		// Verspätung vorhanden? Den User auch benachrichten!
		if($exchangeTimeInt > 0) {
			$delayObject = new \Game\Task\Journey\Delay('Verzögerungen beim Ein- und Ausstieg. Das Fahrzeug hat nicht genügend Kapazität!', $exchangeTime);
			$this->addDelay($delayObject);
		}
		
		return $exchangeTime;
	}
	
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
		$calcedTime = $pathUnit->calcTimeWithTrainUnit($trainUnit, TrainUnit::CURRENT_WEIGHT, $neededStations, false)[$nextStation->getID()];
		$scheduledTime = $taskSchedule->getTimesForStation($nextStation, false)['arrival'];
		
		// Berechnete Zeit länger als die im Fahrplan eingetragene Zeit
		if($calcedTime > $scheduledTime) {
			// Verspätung hinzufügen
			$delayTime = new \Core\Time($fullPathTime->toInt() - $scheduledDepartureTime->toInt());
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
		
		$currentStepID = array_search($this->currentStation, $stations);
		$nextStepID = $currentStepID+1;
		
		return $stations[$nextStepID];
	}
}

?>