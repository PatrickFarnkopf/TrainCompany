<?php
/**
*
* Verwaltet die Jahreszeiten.
* Datum: 31. Oktober 2012
*
**/
namespace Game;

class Season extends \Core\Data {
	use \Core\Data\Vars;
	
	/**
	* Gibt einen Reibungsfaktor für die Züge zurück.
	*
	* @return String - Reibungsfaktor
	**/
	public function getRubbingFactor() {
		return $this->properties['rubbingFactor'];
	}
}
?>