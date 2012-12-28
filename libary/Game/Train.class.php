<?php
/**
*
* Verwaltet die Züge.
* Datum: 24. Oktober 2012
*
**/
namespace Game;

class Train extends Data {
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
	* Setzt die Kapäzität des Fahrzeugs.
	*
	* @param array $capacityArray - array(Kapazitättype => Anzahl)
	**/
	public function setCapacity(array $capacityArray) {
		$this->properties['capacity'] = $capacityArray;
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
	* Setzt die maximale Geschwindigkeit des Fahrzeugs.
	*
	* @param int $speed - Maximale Geschwindigkeit in km/h
	**/
	public function setSpeed($speed) {
		$this->properties['speed'] = $speed;
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
	* Setzt die Länge des Fahrzeugs.
	*
	* @param int $length - Länge des Fahrzeugs
	**/
	public function setLength($length) {
		$this->properties['length'] = $length;
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
	* Setzt das Gewicht des Fahrzeugs.
	*
	* @param float $weight - Gewicht in t
	**/
	public function setWeight($weight) {
		$this->properties['weight'] = $weight;
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
	* Setzt die Zugkraft des Fahrzeugs.
	*
	* @param int $force - Zugkraft in kN
	**/
	public function setForce($force) {
		$this->properties['force'] = $force;
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
	* Setzt die Antriebsart des Fahrzeugs.
	*
	* @param DIESEL_DRIVE/ELECTRO_DRIVE/NO_DRIVE $drive - Diesel-Antrieb, Elektro-Antrieb oder gar kein Antrieb?
	**/
	public function setDrive($drive) {
		$this->properties['drive'] = $drive;
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
	* Setzt den Preis des Fahrzeugs.
	*
	* @param int $cost - Preis in Plops
	**/
	public function setCost($cost) {
		$this->properties['cost'] = $cost;
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
	* Setzt die Anzahl der Triebzüge, die maximal miteinander gekoppelt werden können.
	* Nur bei Triebzügen interessant.
	*
	* @param int $units - Anzahl der Einheiten. (0 = Unbegrenzt)
	**/
	public function setMaxConnectedUnits($units) {
		$this->properties['maxConnectedUnits'] = $units;
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
	* Setzt die Start-Zuverlässigkeit
	*
	* @param float $reliability - Zuverlässigkeit
	**/
	public function setReliability($reliability) {
		$this->properties['reliability'] = $reliability;
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