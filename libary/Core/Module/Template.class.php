<?php
/**
*
* Diese Klasse ersetzt Platzhalter aus Templates durch die passenden Ausdrücke.
* Datum: 21.12.2012
*
**/
namespace Core\Module;

class Template extends Compiler {
	const CACHE_DIR = 'cache/templates/';
	
	/**
	* Nimmt den Namen des Template-Files entgegen und gibt das Template aus.
	*
	* @param string $filename - Zum ROOT_PATH relativer Pfad zum Template-File
	* @param array $vars - Variablen die dem Template mitgegeben werden sollen. [optional]
	**/
	public function __construct($filename, array $vars = array()) {
		parent::__construct($filename, $vars); 
		
		// Die Datei einbinden
		require ROOT_PATH.$this->getCacheFileName();
	}
	
	/**
	* Eigentliche Haupt-Methode dieser Klasse. Kompiliert das Template.
	**/
	protected function recompile() {
		// Inhalt der Datei laden
		$templateContent = file_get_contents(ROOT_PATH.$this->getFileName());
		
		// Was soll alles ersetzt werden?
		$replacements = array();
		$replacements['/\?\?\?([a-zA-Z0-9]*)\?\?\?/'] = '\Core\i::Module()->issetVarCache(\'\1\')';
		$replacements['/\!\!\!([a-zA-Z0-9]*)\!\!\!/'] = '\Core\i::Module()->getVarCache(\'\1\')';
		$replacements['/>>>/'] = '\Core\Module::createModuleLink';
		$replacements['/\^\^\^/'] = '\Core\i::Module()->includeTemplate';
		
		// Strings umsetzen
		foreach($replacements as $currentPattern=>$currentReplacement)
			$templateContent = preg_replace($currentPattern,$currentReplacement,$templateContent);
			
		// \Core\Format soll als „Format“ verwendbar sein
		$templateContent = '<?php use \Core\Format; ?>'.$templateContent;
			
		// Inhalt in die Cache-Datei schreiben
		file_put_contents(ROOT_PATH.$this->getCacheFileName(), $templateContent);
	}
}
?>