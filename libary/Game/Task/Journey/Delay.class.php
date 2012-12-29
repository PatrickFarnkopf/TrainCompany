<?php
/**
*
* Eine Verspätung während einer Zugfahrt
* Datum: 17. Dezember 2012
*
**/
namespace Game\Task\Journey;

class Delay {
	private $description, $time;
	
	/**
	* Erstellt eine neue Verspätung.
	*
	* @param string $description - Wieso ist der Zug verspätet?
	* @param Time $time - Wie viel ist der Zug verspätet?
	**/
	public function __construct($description, \Core\TimeDuration $time) {
		$this->description = $description;
		$this->time = $time;
	} 
	
	/**
	* Gibt den Verspätungsgrund zurück.
	*
	* @return string - Grund
	**/
	public function getDescription() {
		return $this->description;
	}
	
	/**
	* Gibt die Dauer der Verspätung zurück.
	*
	* @return Time - Dauer
	**/
	public function getTime() {
		return $this->time;
	}
}
?>