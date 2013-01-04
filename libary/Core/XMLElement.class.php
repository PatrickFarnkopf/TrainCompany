<?php
/**
*
* XML-Element, mit einigen Zusatzfunktionen
* Datum: 2. Januar 2012
*
*/
namespace Core;

class XMLElement extends \SimpleXMLElement {
	/**
	* Erstellt ein Element aus dem Inhalt der angebenen Datei.
	*
	* @param string $filename - Dateiname
	* @return self
	**/
	public static function loadFile($fileName) {
		try {
			return simplexml_load_file($fileName, __CLASS__);
		} catch (\Exception $exception) {
			throw new \Exception('Die angeforderte XML-Datei konnte nicht geladen werden.', 1160, $exception);
		}
	}

	/**
	* Macht aus sich selbst ein Array. Rekursiv!
	*
	* @return array
	**/
	public function toArray() {
		$array = (array) $this;
		
		// Den @attributes entfernen
		unset($array['@attributes']);

		foreach(array_slice($array,0) as $key=>$value) {		
			if($value instanceof self && !is_null($value))
				$array[$key] = $value->toArray();
		}
		
		// Ungewollte verschachtelte Arrays vermeiden.
		if(count($array) == 1 && is_array(array_values($array)[0]))
			$array = array_values($array)[0];
		
		return $array;
	}
}
?>