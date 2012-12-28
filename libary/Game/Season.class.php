<?php
/**
*
* Verwaltet die Jahreszeiten.
* Datum: 31. Oktober 2012
*
**/
namespace Game;

class Season extends Data {
	use \Core\Data\Vars;
	
	/**
	* Setzt einen Reibungsfaktor für die Züge.
	*
	* @param String $factor - Reibungsfaktor
	**/
	public function setRubbingFactor($factor) {
		$this->properties['factor'] = $factor;
	}
	
	/**
	* Gibt einen Reibungsfaktor für die Züge zurück.
	*
	* @return String - Reibungsfaktor
	**/
	public function getRubbingFactor() {
		return $this->properties['factor'];
	}
}
?>