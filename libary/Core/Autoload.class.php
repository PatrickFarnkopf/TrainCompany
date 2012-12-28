<?php
/**
* 
* Lädt benötigte Klassen nach.
*
* Datum: 20.12.2012
*
**/
namespace Core;

class Autoload {
	const MAIN_INSTANCE_ALIAS = 'i';
	const CLASS_DIR = 'libary/';
	
	private $classname;
	
	/**
	* Verarbeitet die Anfrage einer Klasse.
	*
	* @param string $classname - Name der Klasse
	**/
	public function __construct($classname) {
		$this->classname = new Classname($classname);
		
		// Heißt die Klasse „i“? Dann wird wohl die MainInstance Klasse erwartet
		if($this->classname->getClassname() == self::MAIN_INSTANCE_ALIAS) $this->aliasMainInstanceClass();
		else $this->includeClassFile();
	}
	
	/**
	* Erstellt einen „Alias“ für die MainInstance-Klasse.
	*	Wichtig: Es wird kein richtiger Alias erstellt, da der Namespace für uns sehr wichtig ist.
	**/
	private function aliasMainInstanceClass() {
		Alias::forClass(new Classname('\Core\MainInstance'), $this->classname);
	}
	
	/**
	* Versucht die angeforderte Klasse
	**/
	private function includeClassFile() {
		$dirName = ROOT_PATH.self::CLASS_DIR;
		
		// Verzeichnis der Klasse heißt so wie der Namespace
		$dirName .= implode('/', $this->classname->getNamespace()).'/';
		
		// Nicht nur bei Klassen wird der Autoloader aufgerufen. Auch bei Interfaces und Traits.
		foreach(array('class','interface','trait') as $current) {
			// Datei-Name bilden
			$fileName = $dirName.$this->classname->getClassname();
			$fileName .= '.'.$current.'.php';
			
			// Existiert diese Datei? Wenn ja: Datei einbinden und restliche Methode abbrechen.
			if(file_exists($fileName)) {
				require_once $fileName;
				
				// Überprüfen ob Class/Interface/Trait gesucht ist
				$functionName = $current.'_exists';
				
				// Ist in dieser Datei auch die erwartete Klasse enthalten?
				if(!$functionName($this->classname->getFullClassname()))
					throw new \Exception('Für die/das Klasse/Interface/Trait „'.$this->classname->getFullClassname().'“ existiert zwar eine Datei, in dieser befindet sich aber nicht die/das erwartete Klasse/Interface/Trait.', 1081);
				
				return;
			}
		}
		
		// Ohh, keine Klasse gefunden. :(
		throw new \Exception('Die/Das angeforderte Klasse/Interface/Trait „'.$this->classname->getFullClassname().'“ existiert nicht.', 1080);
	}
} 
?>