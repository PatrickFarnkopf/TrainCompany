<?php
/**
* 
* Lädt benötigte Klassen, Interfaces und Traits nach.
*
* Datum: 20.12.2012
*
**/
namespace Core;

class Autoload {
	const CLASS_DIR = 'libary/';
	
	private $classname;
	private static $beforeCallbacks = [], $afterCallbacks = [];
	
	/**
	* Verarbeitet die Anfrage einer Klasse.
	*
	* @param string $classname - Name der Klasse
	**/
	public function __construct($classname) {
		$this->classname = new Classname($classname);
		
		// Registrierte Callbacks abarbeiten
		foreach(self::$beforeCallbacks as $currentCallback) {
			call_user_func($currentCallback, $this->classname);
			
			// Existiert nach diesem Aufruf diese(s) Klasse/Interface/Trait?
			foreach(['class','interface','trait'] as $current) {
				if(call_user_func($current.'_exists', (string)$this->classname, false)) return;
			}
		}
		
		// Klassen-Datei einfügen
		$this->includeClassFile();
		
		// Registrierte Callbacks abarbeiten
		foreach(self::$afterCallbacks as $currentCallback)
			$return = call_user_func($currentCallback, $this->classname);
	}
	
	/**
	* Versucht die angeforderte Klasse
	**/
	private function includeClassFile() {
		$dirName = ROOT_PATH.self::CLASS_DIR;
		
		// Verzeichnis der Klasse heißt so wie der Namespace
		$dirName .= implode('/', $this->classname->getNamespace()).'/';
		
		// Nicht nur bei Klassen wird der Autoloader aufgerufen. Auch bei Interfaces und Traits.
		foreach(['class','interface','trait'] as $current) {
			// Datei-Name bilden
			$fileName = $dirName.$this->classname->getClassname();
			$fileName .= '.'.$current.'.php';
			
			// Existiert diese Datei? Wenn ja: Datei einbinden und restliche Methode abbrechen.
			if(file_exists($fileName)) {
				require_once $fileName;

				// Ist in dieser Datei auch die erwartete Klasse enthalten?
				if(!call_user_func($current.'_exists', (string)$this->classname, false))
					throw new \Exception('Für die/das Klasse/Interface/Trait „'.$this->classname.'“ existiert zwar eine Datei, in dieser befindet sich aber nicht die/das erwartete Klasse/Interface/Trait.', 1081);
				
				return;
			}
		}
		
		// Ohh, keine Klasse gefunden. :(
		throw new \Exception('Die/Das angeforderte Klasse/Interface/Trait „'.$this->classname.'“ existiert nicht.', 1080);
	}
	
	/**
	* Registriert ein Callback für den Autoloader, das bevor die Klasse geladen wird ausgeführt wird.
	*
	* @param callable $callback
	**/
	public static function registerBeforeCallback(callable $callback) {
		self::$beforeCallbacks[] = $callback;
	}
	
	/**
	* Registriert ein Callback für den Autoloader, das nachdem die Klasse geladen wird ausgeführt wird.
	*
	* @param callable $callback
	**/
	public static function registerAfterCallback(callable $callback) {
		self::$afterCallbacks[] = $callback;
	}
} 
?>