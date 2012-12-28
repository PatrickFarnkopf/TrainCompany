<?php
/**
*
* Verwaltet die Kapazitäten.
* Datum: 24. Oktober 2012
*
**/
namespace Game;

class Capacity extends Data {
	use \Core\Data\Vars;
	
	/**
	* Setzt die Einheit der Kapazität
	*
	* @param String $unit - Einheit
	**/
	public function setUnit($unit) {
		$this->properties['unit'] = $unit;
	}
	
	/**
	* Gibt die Einheit dieser Kapazität zurück.
	*
	* @return String - Einheit
	**/
	public function getUnit() {
		return $this->properties['unit'];
	}
	
	/**
	* Setzt ein Icon der Kapazität
	*
	* @param String $iconName - Icon
	**/
	public function setIcon($iconName) {
		$this->properties['iconName'] = $iconName;
	}
	
	/**
	* Gibt das Icon dieser Kapazität zurück.
	*
	* @return String - Icon
	**/
	public function getIcon() {
		return $this->properties['iconName'];
	}
	
	/**
	* Setzt das Gewicht in Tonnen für eine Einheit.
	*
	* @param float $unitMass - Eine Einheit in Tonnen. (z.B.: Ein Passagier = 0,07 Tonnen)
	**/
	public function setUnitMass($unitMass) {
		$this->properties['unitMass'] = $unitMass;
	}
	
	/**
	* Gibt das Gewicht in Tonnen für eine Kapazität zurück.
	*
	* @return float - Eine Einheit in Tonnen. (z.B.: Ein Passagier = 0,07 Tonnen)
	**/
	public function getUnitMass() {
		return $this->properties['unitMass'];
	}
}
?>