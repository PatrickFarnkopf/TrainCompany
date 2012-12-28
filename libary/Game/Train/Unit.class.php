<?php
/**
*
* Verwaltet Zugeinheiten
* Datum: 24. Oktober 2012
*
**/
namespace Game\Train;

class Unit {
	const MAX_LENGTH = 750;
	
	const EMPTY_WEIGHT = 0;
	const CURRENT_WEIGHT = 1;
	const MAX_WEIGHT = 2;

	private $trains = array();
	private $usedCapacity = array();
	private $cache = array();
	private $locked = false;
	
	/**
	* Überprüft, ob die Züge hinzugefügt werden können.
	*
	* @param array $trains - Die Züge als Array
	* @return bool
	**/
	private function checkAddTrains(array $trains) {
		// Eine tmp Zugeinheit bilden, um alles durchzutesten.
		$tmpTrainUnit = new self();
		$tmpTrainUnit->addTrains($trains, false, false);
		
		// Herausfinden, ob es sich um Triebzüge handelt.
		$currentSingleTrainUnit = $this->isSingleTrainUnit();
		try {
			$newSingleTrainUnit = $tmpTrainUnit->isSingleTrainUnit();
			
			// Eigene und tmp Zugeinheit nicht leer, aber eine andere Art? Fehler -1
			if(!is_null($currentSingleTrainUnit) && !is_null($newSingleTrainUnit) && $newSingleTrainUnit !== $currentSingleTrainUnit)
				throw new \Exception();
		} catch (\Exception $exception) {
			throw new \HumanException('Triebzüge können nur mit sich selbst verbunden werden. Diese Kombination kann deswegen nicht gebildet werden.',-1,$exception);
		}
		
		
		// Den Antrieb der Zugeinheiten herausfinden.
		$currentDriveType = $this->getDrive();
		try {
			$newDriveType = $tmpTrainUnit->getDrive();
			
			// Eigene und tmp Zugeinheit nicht unangetrieben, aber andere Antrieb? Fehler -2
			if($currentDriveType != \Game\Train::NO_DRIVE && $newDriveType != \Game\Train::NO_DRIVE && $newDriveType != $currentDriveType)
				throw new \Exception();
		} catch (\Exception $exception) {
			throw new \HumanException('Du kannst kein Diesel-Fahrzeug mit einem Elektro-Fahrzeug verbinden.',-2,$exception);
		}
		
		
		// Länge der beiden Zugeinheiten zusammen über slef::Max_LENGTH? Fehler -3
		if($tmpTrainUnit->getLength() + $this->getLength() > self::MAX_LENGTH)
			throw new \HumanException('Der Zug darf maximal '.\Core\Format::unit(\Core\Format::number(self::MAX_LENGTH),'m').' lang sein.',-3);
		
		// Eigene und tmp Zugeinheit nicht leer und Triebzüge?
		if(!is_null($currentSingleTrainUnit) && $currentSingleTrainUnit !== false
			&& !is_null($newSingleTrainUnit) && $newSingleTrainUnit !== false) {
			$maxUnits = \Game\Train::getObjectForID($currentSingleTrainUnit)->getMaxConnectedUnits(); // Wie viel Einheit darf der Triebzug haben?
			if($maxUnits > 0 && $tmpTrainUnit->countTrains() + $this->countTrains() > $maxUnits)
				throw new \HumanException('Diese Triebzüge dürfen maximal '.\Core\Format::number($maxUnits).'-mal miteinander verbunden werden.',-4);
		}
		
		// Alles okay?
		return true;
	}
	
	/**
	* Fügt mehrere Züge einer Zugeinheit hinzu.
	*
	* @param array $trains - Mehrere Züge
	* @param bool $sort - Zugeinheit danach neusortieren? [optional]
	* @param bool $check [optional]
	**/
	public function addTrains(array $trains, $sort = true, $check = true) {
		if($check) $this->checkAddTrains($trains);
	
		foreach($trains as $currentTrain)
			$this->trains[] = $currentTrain;
		
		if($sort) $this->sortTrainUnit();
		$this->clearCache();
	}
	
	/**
	* Löscht einen Zug aus der Zugeinheit. Wenn keiner gefunden ist, dann ist auch gut.
	* 
	* @param Train $train - Ein Zug aus der Zugeinheit löschen
	* @param bool $sort - Zugeinheit danach neusortieren? [optional]
	**/
	public function removeTrain(\Game\Train $train,$sort=true) {
		$tmpTrains = $this->trains;
		foreach($tmpTrains as $key=>$currentTrain) {
			if($train==$currentTrain) {
				unset($this->trains[$key]);
				break;
			}
		}
		
		if($sort) $this->sortTrainUnit();
		$this->clearCache();
	}
	
	/**
	* Löscht mehrere Züge aus der Zugeinheit
	*
	* @param array $trains - Ein Array mit meheren Zügen
	* @param bool $sort - Zugeinheit danach neusortieren? [optional]
	**/
	public function removeTrains(array $trains,$sort=true) {
		foreach($trains as $currentTrain) $this->removeTrain($currentTrain, false);
		
		if($sort) $this->sortTrainUnit();
	}
	
	/**
	* Leert den Cache der Zugeinheit
	**/
	private function clearCache() {
		$this->cache = array();
	}
	
	/**
	* Teilt eine Zugeinheit nach dem x-ten Element und gibt eine neue Zugeinheit mit diesen Elementen zurück.
	*
	* @param int $element - Erstes Element, der neuen Zugeinheit.
	* @param bool $sort - Zugeinheit danach neusortieren? [optional]
	* @return TrainUnit - Neue Zugeinheit
	**/
	public function splitUpUnitBefore($element,$sort=true) {
		$splitedTrains = array();
		for($i=$element; $i < count($this->trains);$i++) $splitedTrains[] = $this->trains[$i];
		
		$newTrainUnit = new self();
		$newTrainUnit->addTrains($splitedTrains);
		$this->removeTrains($splitedTrains);
		
		if($sort) $this->sortTrainUnit();
		
		return $newTrainUnit;
	}
	
	/**
	* Sortiert die Zugeinheit.
	*  -> Lokomotiven alle nach vorne, gleiche Wagentypen direkt hintereinander
	*     Vorne <-> Hinten
	**/
	public function sortTrainUnit() {
		$tmpLocoArray = array();
		$tmpTrainArray = array();
		foreach($this->trains as $currentTrain) {
			if($currentTrain->getGroup() == \Game\Train::GROUP_LOCO) $varName = 'tmpLocoArray';
			else $varName = 'tmpTrainArray';
			
			if(!isset(${$varName}[$currentTrain->getID()])) ${$varName}[$currentTrain->getID()] = array();
			${$varName}[$currentTrain->getID()][] = $currentTrain;
		}
		
		$trains = array();
		foreach($tmpLocoArray as $currentLoco=>$objects) {
			foreach($objects as $currentTrain) $trains[] = $currentTrain;
		}
		foreach($tmpTrainArray as $currentTrain=>$objects) {
			foreach($objects as $currentTrain) $trains[] = $currentTrain;
		}
		
		$this->trains = $trains;
	}
	
	/**
	* Gibt alle Fahrzeuge, die in diese Einheit gekuppelt sind, zurück.
	*
	* @return array - Züge
	**/
	public function listTrains() {
		return $this->trains;
	}
	
	/**
	* Gibt die Anzahl der Züge in dieser Einheit zurück
	*
	* @return int
	**/
	public function countTrains() {
		return count($this->trains);
	}
	
	
	/**
	* Zählt, wie oft ein bestimmter Zug in dieser Einheit vorkommt
	*
	* @param Train $train - Zug, der gesucht ist
	* @return int - Anzahl der Vorkommen
	**/
	public function searchTrain(\Game\Train $train) {
		return count(array_keys($this->trains, (string)$train));
	}
	
	/**
	* Gibt zurück, ob es sich um eine Zugeinheit handelt, wenn ja um welche.
	*
	* @return bool/int - Entweder false oder eine Zug-ID
	**/
	public function isSingleTrainUnit() {
		if(isset($this->cache['singleTrainUnit'])) return $this->cache['singleTrainUnit'];
		
		$trainUnit = NULL;
		foreach($this->trains as $currentTrain) {
			if(($currentTrain->getGroup() != \Game\Train::GROUP_UNIT && $trainUnit === false)
				|| ($currentTrain->getGroup() == \Game\Train::GROUP_UNIT && $trainUnit === $currentTrain->getID())) continue;
			
			if($currentTrain->getGroup() != \Game\Train::GROUP_UNIT && is_null($trainUnit)) $trainUnit = false;
			else if($currentTrain->getGroup() == \Game\Train::GROUP_UNIT && is_null($trainUnit)) $trainUnit = $currentTrain->getID();
			else throw new \Exception('Es sind ungültige Zugkombinationen in dieser Zugeinheit, die Art der Zugeinheit konnte nicht ermittelt werden.', 27);
		}
		
		$this->cache['singleTrainUnit'] = $trainUnit;
		return $trainUnit;
	}
	
	/**
	* Gibt die Kapazitäten der Zugeinheit als Array zurück
	*
	* @return array - Kapaztiäten
	**/
	public function getCapacity() {
		if(isset($this->cache['capacity'])) return $this->cache['capacity'];
		
		$capacities = array();
		foreach($this->trains as $trainObject) $capacities[] = $trainObject->getCapacity();
		$capacity = \Core\addArrayContent($capacities);
		
		$this->cache['capacity'] = $capacity;
		return $capacity;
	}
	
	/**
	* Gibt alle Kapazitäten, die angeben sind, addiert zurück.
	*
	* @param array $capacities - Die Kapazitäten (Bitte nicht als Objekt, sondern als ID)
	* @return int
	**/
	public function getFullCapacity(array $capacities) {
		$full = 0;
		foreach($this->getCapacity() as $capacity => $value) {
			if(!in_array($capacity, $capacities)) continue;
			
			$full += $value;
		}
		
		return $full;
	}
	
	/**
	* Neue Kapazität benutzen.
	*
	* @params array $useCapacity - Was „steigt zu“?
	**/
	public function useCapacity(array $useCapacity) {
		$capacity = $this->getCapacity();
		$usedCapacity = $this->usedCapacity;
		
		$usedCapacity = addArrayContent(array($usedCapacity,$useCapacity));
		
		foreach($usedCapacity as $key=>$currentCapacityUsed) {
			if ($capacity[$key] < $currentCapacityUsed)
				throw new \Exception('Der Zug ist bereits voll ausgelastet.', 2081);
		}
		
		$this->usedCapacity = $usedCapacity;
	}
	
	/**
	* Gibt Kapazitäten wieder frei.
	*
	* @param array $freeCapacity - Was „steigt aus“?
	**/
	public function freeCapacity(array $freeCapacity) {
		$usedCapacity = $this->usedCapacity;
		
		$usedCapacity = addArrayContent(array($usedCapacity,$freeCapacity));
		
		foreach($usedCapacity as $key=>$currentCapacityUsed) {
			if (0 > $currentCapacityUsed)
				throw new \Exception('Der Zug kann nicht mehr Kapazität freigeben, wie er benutzt ist.', 2080);
		}
		
		$this->usedCapacity = $usedCapacity;
	}
	
	/**
	* Gibt aus, wie viel Kapazitäten genutzt sind.
	*
	* @return array - Welche Kapazitäten sind genutzt?
	**/
	public function getUsedCapacity() {
		return $this->usedCapacity;
	}
	
	/**
	* Gibt den Antrieb des Einheit an, wenn mindestens ein angetriebenes Fahrzeug vorhanden ist.
	*
	* @return DIESEL_DRIVE/ELECTRO_DRIVE/NO_DRIVE $drive - Diesel-Antrieb, Elektro-Antrieb oder gar kein Antrieb?
	**/
	public function getDrive() {
		if(isset($this->cache['drive'])) return $this->cache['drive'];
	
		$currentDrive = \Game\Train::NO_DRIVE;
		foreach($this->trains as $trainObject) {
			if($trainObject->getDrive() == \Game\Train::NO_DRIVE) continue;
			
			if($currentDrive == \Game\Train::NO_DRIVE || $trainObject->getDrive() == $currentDrive) $currentDrive = $trainObject->getDrive();
			else throw new Exception('Es sind ungültige Antriebs-Kombinationen in dieser Zugeinheit, die Antriebsart konnte nicht ermittelt werden.', 28); 
		} 
		
		$this->cache['drive'] = $currentDrive;
		return $currentDrive;
	}
	
	/**
	* Berechnet das Leergewicht dieser Zugeinheit
	*
	* @param int $weightType - Welches Gewicht?
	* @return int - Leergewicht
	**/
	public function getWeight($weightType) {
		$currentWeight = 0;
		foreach($this->trains as $trainObject) $currentWeight += $trainObject->getWeight();
		
		switch($weightType) {
			case self::CURRENT_WEIGHT:
				foreach($this->usedCapacity as $capacity => $used)
					$currentWeight += \Game\Capacity::getObjectForID($capacity)->getUnitMass() * $used;
				break;
			case self::MAX_WEIGHT:
				foreach($this->getCapacity() as $capacity => $used)
					$currentWeight += \Game\Capacity::getObjectForID($capacity)->getUnitMass() * $used;
				break;
		}
		
		return $currentWeight;
	}
	
	/**
	* Berechnet die Gesamt-Zugkraft der Einheit
	*
	* @return int - Leergewicht
	**/
	public function getForce() {
		if(isset($this->cache['force'])) return $this->cache['force'];
		
		$force = 0;
		foreach($this->trains as $trainObject) $force += $trainObject->getForce();
		
		$this->cache['force'] = $force;
		return $force;
	}
	
	/**
	* Berechnet die Beschleunigung für die Zugeinheit.
	*
	* @param int $weightType - Welches Gewicht?
	* @return float - Beschleunigung in m/s^2
	**/
	public function getSpeedup($weightType) {
		if($this->getWeight($weightType) != 0) $speedup = ($this->getForce() / $this->getWeight($weightType)) * \Game\Train::getRubbingFactor();
		else $speedup = 0;
		
		return $speedup;
	}
	
	/**
	* Berechnet die Maximal-Geschwindigkeit der Zugeinheit
	*
	* @return int - Max-Geschwindigkeit
	**/
	public function getSpeed() {
		if(isset($this->cache['speed'])) return $this->cache['speed'];
	
		$maxSpeed = false;
		foreach($this->trains as $trainObject) {
			if(!$maxSpeed || $maxSpeed > $trainObject->getSpeed())
				$maxSpeed = $trainObject->getSpeed();
		}
		
		$this->cache['speed'] = $maxSpeed;
		return $maxSpeed;
	}
	
	/**
	* Gibt den Wiederverkauswert der Zugeinheit zurück
	*
	* @return int - Wiederverkaufswert
	**/
	public function getSellPrice() {	
		$sellPrice = 0;
		foreach($this->trains as $trainObject) $sellPrice += $trainObject->getSellPrice();
		
		return $sellPrice;
	}
	
	/**
	* Gibt das durschnittliche Alter der Fahrzeuge dieser Einheit zurück
	*
	* @return float - Alter in Jahren
	**/
	public function getAverageAge() {
		$ages = 0;
		foreach($this->trains as $trainObject) $ages += $trainObject->getAge();
		
		return $ages / count($this->trains);
	}
	
	/**
	* Gibt die aktuelle Zuverlässigkeit der Zugeinheit aus
	*
	* @return float - Zuverlässigkeit
	**/
	public function getReliability() {
		$reliability = false;
		foreach($this->trains as $trainObject) {
			if(!$reliability || $reliability > $trainObject->getReliability())
				$reliability = $trainObject->getReliability();
		}
		
		return $reliability;
	}
	
	/**
	* Gibt die Länge der Zug-Einheit zurück
	*
	* @return int - Länge des Zuges
	**/
	public function getLength() {
		if(isset($this->cache['length'])) return $this->cache['length'];
	
		$length = 0;
		foreach($this->trains as $trainObject) $length += $trainObject->getLength();
		
		$this->cache['length'] = $length;
		return $length;
	}
	
	/**
	* Sperrt eine Zugeinheit. (Gerade unterwegs.)
	**/
	public function lock() {
		$this->locked = true;
	}
	
	/**
	* Entsperrt eine Zugeinheit.
	**/
	public function unlock() {
		$this->locked = false;
	}
	
	/**
	* Ist die Zugeinheit gesperrt?
	*
	* @return bool
	**/
	public function isLocked() {
		return $this->locked;
	}
	
	/**
	* Fügt mehrere Zugeinheiten zu einer zusammen
	*
	* @param array[TrainUnit] $trainUnits - Array mit mehreren TrainUnit-Instanzen
	* @return TrainUnit - Eine neue TrainUnit-Instanz.
	**/
	public static function fuseTrainUnits(array $trainUnits) {
		$newTrainUnit = new self();
		
		foreach($trainUnits as $currentTrainUnit) $newTrainUnit->addTrains($currentTrainUnit->listTrains());
		
		return $newTrainUnit;
	}
}
?>