<?php
/**
*
* Psyeudo Datentyp für Zeiten
*
* Datum: 2. Dezember 2012
*
**/
namespace Core;

class Time {
	private $time;
	
	/**
	* Neue Zeit
	*
	* @param int $time - Zeit in Sekunden [optional]
	**/
	public function __construct($time=0) {
		$this->time = $time;
	}	
	
	/**
   	* Gibt die Stunden dieser Zeit zurück
   	*
   	* @return string
   	**/
   	public function getHours() {
   		$hours = floor($this->time / 60 / 60);
   		
   		return sprintf('%02d', $hours);
   	}
   	
   	/**
   	* Gibt die Minuten dieser Zeit zurück
   	*
   	* @return string
   	**/
   	public function getMinutes() {
   		$minutes = floor($this->time / 60);
   		$minutes -= $this->getHours()*60;
   		
   		return sprintf('%02d', $minutes);
   	}
   	
   	/**
   	* Gibt die Sekunden dieser Zeit zurück
   	*
   	* @return string
   	**/
   	public function getSeconds() {
   		$seconds = $this->time % 60;
   	
   		return sprintf('%02d', $seconds);
   	}
	
	/**
	* Gibt die Zeit als formatierten String zurück.
	*
	* @param bool $withSeconds [optional]
	* @return string
	**/
   	public function toString($withSeconds=false) { 
   		if($withSeconds) $this->getHours().':'.$this->getMinutes().':'.$this->getSeconds();
    
   		return $this->getHours().':'.$this->getMinutes();
   	}
   	
   	/**
   	* Magische Methode zur String-Umwandlung
   	*
   	* @return string
   	**/
   	public function __toString() {
		return $this->toString();	
   	}
   	
   	/**
   	* Gibt die Zeit als Integer-Wert zurück.
   	*
   	* @return int
   	**/
   	public function toInt() {
	   	return $this->time;
   	}
 
   	
   	/**
   	* Neue Zeit durch Angabe von Minuten und Sekunden
   	*
   	* @param int $minutes
   	* @param int $seconds
   	**/
   	public static function withHoursAndMinutes($hours,$minutes) {
   		$minutes = $hours*60 + $minutes;
   		$seconds = $minutes*60;
   		
	   	return new self($seconds);
   	}
}
?>