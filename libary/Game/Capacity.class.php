<?php
/**
*
* Verwaltet die Kapazitäten.
* Datum: 24. Oktober 2012
*
**/
namespace Game;

class Capacity extends \Core\Data {
	use \Core\Data\Vars;
	
	/**
	* Gibt die Einheit dieser Kapazität zurück.
	*
	* @return String - Einheit
	**/
	public function getUnit() {
		return $this->properties['unit'];
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
	* Gibt das Gewicht in Tonnen für eine Kapazität zurück.
	*
	* @return float - Eine Einheit in Tonnen. (z.B.: Ein Passagier = 0,07 Tonnen)
	**/
	public function getUnitMass() {
		return $this->properties['unitMass'];
	}
}
?>