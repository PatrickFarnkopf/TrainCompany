<?php
/**
*
* Verwaltet die Züge.
* Datum: 24. Oktober 2012
*
**/
namespace Game;

class Train extends \Core\Data {
	use \Core\Data\Vars;
	
	const GROUP_LOCO = 0;
	const GROUP_WAGON = 1;
	const GROUP_UNIT = 2;
	
	const DIESEL_DRIVE = 1;
	const ELECTRO_DRIVE = 0;
	const NO_DRIVE = -1;
	
	const AGING_FACTOR = 0.95;
	
	/**
	* Setzt die aktuelle Unix-Zeit als Kaufzeit
	**/
	public function setBoughtTime() {
		$this->varProperties['boughtTime'] = time();
	}
	
	/**
	* Hat das Fehrzeug eine Kauf-Zeit?
	*
	* @return bool - Ja oder Nein?
	**/
	public function hasBoughtTime() {
		return isset($this->varProperties['boughtTime']);
	}
	
	/**
	* Gibt die Kaufzeit zurück.
	*
	* @return int - Kaufzeit
	**/
	public function getBoughtTime() {
		return $this->varProperties['boughtTime'];
	}

	/**
	* Gibt das Alter in Jahren zurück.
	*
	* @return in - Alter in Jahren
	**/
	public function getAge() {
		return Play::calcYearsSinceTime($this->getBoughtTime());
	}
	
	/**
	* Gibt den Wiederverkauswert des Fahrzeugs zurück
	*
	* @return int - Wiederverkaufswert
	**/
	public function getSellPrice() {
		$yearsSinceBought = $this->getAge();
		
		return $this->getCost() * pow(self::AGING_FACTOR, $yearsSinceBought + 1);
	}
	
	/**
	* Gibt die Kapazitäten des Zugs als Array zurück
	*
	* @return array - Kapaztiäten
	**/
	public function getCapacity() {
		return $this->properties['capacity'];
	}
	
	/**
	* Gibt die maximale Geschwindigkeit des Zugs zurück
	*
	* @return int - Maximale Geschwindigkeit
	**/
	public function getSpeed() {
		return $this->properties['speed'];
	}
	
	/**
	* Gibt die Länge des Zugs zurück
	*
	* @return int - Länge des Fahrzeugs
	**/
	public function getLength() {
		return $this->properties['length'];
	}
	
	/**
	* Gibt das Gewicht des Zugs zurück
	*
	* @return float - Gewicht
	**/
	public function getWeight() {
		return $this->properties['weight'];
	}
	
	/**
	* Gibt das Zugkraft des Zugs zurück
	*
	* @return int - Zugkraft in kN
	**/
	public function getForce() {
		return $this->properties['force'];
	}
	
	/**
	* Berechnet eine Beschleunigung für den Zug
	*
	* @return float - Beschleunigung in m/s^2
	**/
	public function getSpeedup() {
		return ($this->properties['force'] / $this->properties['weight']) * self::getRubbingFactor();
	}
	
	/**
	* Gibt die Antriebsart des Zugs zurück
	*
	* @return DIESEL_DRIVE/ELECTRO_DRIVE/NO_DRIVE - Antriebsart
	**/
	public function getDrive() {
		return $this->properties['drive'];
	}
	
	/**
	* Gibt die Kosten des Zugs zurück
	*
	* @return int - Kosten des Zuges
	**/
	public function getCost() {
		return $this->properties['cost'];
	}
	
	/**
	* Gibt die Anzahl der Triebzüge, die maximal miteinander gekoppelt werden können zurück.
	*
	* @return int - Anzahl der Einheiten
	**/
	public function getMaxConnectedUnits() {
		return $this->properties['maxConnectedUnits'];
	}
	
	
	/**
	* Gibt die aktuelle Zuverlässigkeit aus
	*
	* @return float - Zuverlässigkeit
	**/
	public function getReliability() {
		if(!$this->hasBoughtTime()) return $this->properties['reliability'];
		
		$yearsSinceBought = $this->getAge();
		
		return $this->properties['reliability'] * pow(self::AGING_FACTOR, $yearsSinceBought);
	}
	
	/**
	* Gibt den Reibungsfaktor zurück. Jahreszeitabhänig.
	*
	* @return float - Reibungsfaktor
	**/
	public static function getRubbingFactor() {
		$currentSeasonID = Play::getCurrentSeasonID();
		return Season::getObjectForID($currentSeasonID)->getRubbingFactor();
	}
}

?>