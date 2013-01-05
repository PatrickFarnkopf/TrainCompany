<?php
/**
*
* Die Klasse gibt die Main-Instanzen und ID-Instanzen der angeforderten Klasse zurück.
*
* Datum: 2. Dezember 2012
*
**/
namespace Core;

class MainInstance {
	const CLASS_NAME = 'Core\Cache';
	const ALIAS_NAME = 'i';
	
	/**
	* Rückfrage-Funktion für die Autoload-Klasse
	*
	* @param Classname - Angforderter Klassennamen
	* @return bool - Weitere Autoload-Funktionen durchführen? true = nein
	**/
	public static function callback(Classname $classname) {
		// Wenn Klassennamen nicht i ist, abbrechen
		if($classname->getClassname() != self::ALIAS_NAME) return false;
	
		// Alias erstellen
		Alias::forClass(new Classname('\Core\MainInstance'), $classname);
		
		return true;
	}

	/**
	* Alle Klassenmethoden-Aufrufe stellen eine Klasse da, von der wir die Haupt-Instanz mäöchten
	*
	* @param string $name - Klassen-Name, von der wir die Haupt-Instanze möchten.
	* @param array $args - Uninteressant.
	**/
	public static function __callStatic($name, array $args) {
		// Den Klassennamen bilden, dafür brauchen wir unser eigenen Namespace
		$ownClassname = new Classname(get_called_class());
		$ownNamespace = $ownClassname->getNamespaceAsString();
		
		// Eigenen Namespace mit angefordertem Klassennamen kombinieren
		$classname = $ownNamespace.'\\'.$name;
	
		if(!class_exists($classname)) throw new \Exception('Die angeforderte Klasse „'.$classname.'“ existiert nicht.', 1020);
				
		$reflection = new \ReflectionClass($classname);
		if(!$reflection->isSubclassOf(self::CLASS_NAME))
			throw new \Exception('Die angeforderte Klasse „'.$classname.'“ ist keine Tochter der '.self::CLASS_NAME.'-Klasse.', 1021);
		
		// Eine ID angefordert?
		if(count($args))
			return $classname::instanceFor($args[0]);
		
		// Main-Instanz zurückgeben.
		return $classname::mainInstance();
	}
}
?>