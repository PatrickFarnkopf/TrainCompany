<?php
/**
*
* Diese Klasse ist das Grundgerüst einer jeder Skript-Klasse
* Datum: 28.12.2012
*
**/
namespace Core\Module;

abstract class Extender {
	/**
	* Ein Constructor ist Pflicht!
	**/
	abstract public function __construct();
	
	/**
	* Gibt die Modul-Haupt-Instanz zurück.
	*
	* @return \Core\Module
	**/
	protected function mi()  {
		return \Core\i::Module();
	}
	
	/**
	* Gibt die aktuelle User-Instanz zurück.
	*
	* @return \Core\User
	**/
	protected function ui() {
		return \Core\i::Session()->getUserInstance();
	}
	
	/**
	* Gibt die aktuelle Session-Instanz zurück.
	*
	* @return \Core\Session
	**/
	protected function si() {
		return \Core\i::Session();
	}
}
?>