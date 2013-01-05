<?php
/**
*
* Methoden um Variablen in der Klasse zwischen zu speichern.
* Datum: 2. Dezember 2012
*
**/
namespace Core;

trait VarCache {
	protected $varCache = [], $isFunction = [];
	
	/**
	* Fügt eine neue(s) Variable/Array dem Variablen-Cache hinzu. Ist diese nicht vorhanden wird das Skript mit einer Exception beendet.
	*
	* @param String $varName - Der Name im Variablen-Cache
	* @param mixed $newVar - Neue Variable oder Array
	* @param bool $isFunction - Ist das eine Funktion, die erst ausgeführt werden muss? [optional]
	**/
	public function addVarCache($varName, $newVar, $isFunction = false) {
		if (!is_string($varName)) throw new \Exception('Der Variablen-Name im Variablen-Cache muss ein String sein.', 1090);
		$this->varCache[$varName] = $newVar;
		$this->isFunction[$varName] = $isFunction;
	}
	
	
	/**
	* Liest eine Variable/Array aus dem Variablen-Cache. 
	*
	* @param String $varName - Der Name im Variablen-Cache
	* @return mixed - Die Variabel zum Variablen-Name
	**/
	public function getVarCache($varName) {
		if (!$this->issetVarCache($varName)) throw new \Exception('Diese Variable liegt nicht im Variablen-Cache.', 1091);
		
		if($this->isFunction[$varName]) return $this->varCache[$varName](); 
		return $this->varCache[$varName];
	}
	
	/**
	* Überprüft, ob etwas zum Variablen-Name gespeichert ist
	*
	* @param String $varName - Der Name im Variablen-Cache
	* @return bool - Ist die Variable vorhanden?
	**/
	public function issetVarCache($varName) {
		return isset($this->varCache[$varName]);
	}
	
	/**
	* Fügt ein neues Element zu einem Array im VarCache hinzu
	*
	* @param string $varName - Das Array
	* @param mixed $value - Das Element
	* @param int $elementID - ID im Array [optional]
	* @return int - Die ID des Elements
	**/
	public function addElementToVarCache($varName, $value, $elementID = false) {
		if(!$this->issetVarCache($varName)) $this->addVarCache($varName,[]);
		if(!is_array($this->varCache[$varName])) throw new \Exception('Diese Variable ist kein Array.', 1092);
		
		
		if($elementID !== false) {
			$this->varCache[$varName][$elementID] = $value;
			
			return $elementID;
		}
				
		$this->varCache[$varName][] = $value;
		$arrayKey = array_keys($this->varCache[$varName]);
		
		return $arrayKey[count($arrayKey)-1];
	}
	
	/**
	* Löscht ein Element von einem Array im VarCache
	*
	* @param string $varName - Das Array
	* @param string $elementID
	**/
	public function unsetElementInVarCache($varName, $elementID) {
		if(!$this->issetVarCache($varName)) $this->addVarCache($varName,[]);
		if(!is_array($this->varCache[$varName])) throw new \Exception('Diese Variable ist kein Array.', 1092);
		
		unset($this->varCache[$varName][$elementID]);
	}
}
?>