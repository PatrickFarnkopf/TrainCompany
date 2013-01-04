<?php
/**
*
* Verwaltet die Bahnhöfe
* Datum: 6. November 2012
*
**/
namespace Game;

class Station extends \Core\Data {
	use \Core\Data\Vars;
	
	const GROUP_BIG = 0;
	const GROUP_MIDDLE = 1;
	const GROUP_SMALL = 2;
	
	const GROUP_BIG_PASSENGER = 250;
	const GROUP_MIDDLE_PASSENGER = 120;
	const GROUP_SMALL_PASSENGER = 40;
	
	/**
	* Gibt den X-Wert des Bahnhofes zurück
	*
	* @return int - X-Wert
	**/
	public function getX() {
		return $this->properties['x'];
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
	* Gibt die Bahnsteigslänge des Bahnhofes zurück
	*
	* @return int - Bahnsteigslänge
	**/
	public function getPlatformLength() {
		return $this->properties['platformLength'];
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