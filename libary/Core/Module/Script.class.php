<?php
/**
*
* Diese Klasse macht aus Modul-Skripten Pseuydo-Klassen
* Datum: 28.12.2012
*
**/
namespace Core\Module;

class Script extends Compiler {
	const CACHE_DIR = 'cache/scripts/';
	
	/**
	* Nimmt den Namen der Skript-Datei entgegen und führt sie aus.
	*
	* @param string $filename - Zum ROOT_PATH relativer Pfad zum Template-File
	* @param array $vars - Variablen die dem Template mitgegeben werden sollen. [optional]
	**/
	public function __construct($filename, array $vars = array()) {
		parent::__construct($filename, $vars);
		
		// Die Datei einbinden
		require_once ROOT_PATH.$this->getCacheFileName();
		
		// Klassen-Namen ermitteln
		$classname = '\Script\\'.$this->getCacheName();
		
		new $classname();
	}
	
	/**
	* Eigentliche Haupt-Methode dieser Klasse. Kompiliert das Template.
	**/
	protected function recompile() {
		// Inhalt der Datei laden
		$scriptContent = file_get_contents(ROOT_PATH.$this->getFileName());
		
		// „script“ ersetzen
		$count = 0;
		$pattern = '/script(?=([^"\']*["\'][^"\']*["\'])*[^"\']*$)/';
		$replacement = 'namespace Script; class '.$this->getCacheName().' extends \Core\Module\Extender ';
		
		$scriptContent = preg_replace($pattern,$replacement,$scriptContent, -1, $count);
		
		// Dieser Befehl darf genau einmal in der Datei vorkommen
		if($count != 1) throw new \Exception('Es muss genau ein „Script“-Block in jeder Modul-Skript-Datei vorkommen.', 1140);
			
		// Inhalt in die Cache-Datei schreiben
		file_put_contents(ROOT_PATH.$this->getCacheFileName(), $scriptContent);
	}
}
?>