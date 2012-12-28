<?php
/**
*
* Verwaltet die Bahnhöfe
* Datum: 6. November 2012
*
**/
namespace Game;

class Station extends Data {
	use \Core\Data\Vars;
	
	const GROUP_BIG = 0;
	const GROUP_MIDDLE = 1;
	const GROUP_SMALL = 2;
	
	const GROUP_BIG_PASSENGER = 250;
	const GROUP_MIDDLE_PASSENGER = 120;
	const GROUP_SMALL_PASSENGER = 40;
	
	/**
	* Setzt den X-Wert des Bahnhofs
	*
	* @param int $x - X-Wert
	**/
	public function setX($x) {
		$this->properties['x'] = $x;
	}
	
	/**
	* Gibt den X-Wert des Bahnhofes zurück
	*
	* @return int - X-Wert
	**/
	public function getX() {
		return $this->properties['x'];
	}
	
	/**
	* Setzt den Y-Wert des Bahnhofs
	*
	* @param int $y - Y-Wert
	**/
	public function setY($y) {
		$this->properties['y'] = $y;
	}
	
	/**
	* Gibt den Y-Wert des Bahnhofes zurück
	*
	* @return int - Y-Wert
	**/
	public function getY() {
		return $this->properties['y'];
	}
	
	/**
	* Setzt die Bahnsteigslänge des Bahnhofs
	*
	* @param int $platformLength - Bahnsteigslänge
	**/
	public function setPlatformLength($platformLength) {
		$this->properties['platformLength'] = $platformLength;
	}
	
	/**
	* Gibt die Bahnsteigslänge des Bahnhofes zurück
	*
	* @return int - Bahnsteigslänge
	**/
	public function getPlatformLength() {
		return $this->properties['platformLength'];
	}
	
	/**
	* Setzt die Anzahl Bahnsteige des Bahnhofs
	*
	* @param int $platforms - Anzahl
	**/
	public function setPlatforms($platforms) {
		$this->properties['platforms'] = $platforms;
	}
	
	/**
	* Gibt die Anzahl der Bahnsteige des Bahnhofes zurück
	*
	* @return int - Anzahl
	**/
	public function getPlatforms() {
		return $this->properties['platforms'];
	}
	
	/**
	* Gibt an, wie viele Fahrgäste hier umsteigen wollen
	*
	* @return int - Anzahl der Fahrgäste
	**/
	public function getExchangePassenger() {
		// Zufallsfaktor (Anzahl der Bahnsteige kann den Ausschlag geben.)
		$randomFactor = mt_rand(5,$this->getPlatforms()+10)/10;
		
		// Grundwerteherausfinden
		$basicPassengerValue = 0;
		switch($this->getGroup()) {
			case self::GROUP_BIG:
				$basicPassengerValue = self::GROUP_BIG_PASSENGER;
				break;
			case self::GROUP_MIDDLE:
				$basicPassengerValue = self::GROUP_MIDDLE_PASSENGER;
				break;
			case self::GROUP_SMALL:
				$basicPassengerValue = self::GROUP_SMALL_PASSENGER;
				break;
		}
		
		return $basicPassengerValue * $randomFactor;
	}
}
?>