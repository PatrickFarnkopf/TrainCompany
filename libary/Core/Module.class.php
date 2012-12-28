<?php
/**
*
* Die zweite Version einer Modul-Klasse. Diese Klasse stellt die angeforderten Seiten da und passt das Template entsprechend an.
* Datum: 21. Dezember 2012
*
**/
namespace Core;

class Module extends Cache {
	use VarCache, Cache\Vars;

	const MODULE_DIR = 'Modules/';
	const SET_DIR = 'templates/set/';
	const INC_DIR = 'templates/inc/';
	
	const START_MODULE = 'Start';
	const ERROR_MODULE = 'Error';
	
	const GET_NAME = 'module';
	const GET_OPTIONS = 'options';
	
	private $moduleName, $templateSet;
	
	/**
	* Startet eine Instanz der Modul-Klasse und schaut, was geladen werden muss.
	*
	* @param bool $showErrorModule - Soll bei einem nicht vorhandenen Modul statt eine Exception das 404-Module geöffnet werden? [optional]
	**/
	public function __construct($showErrorModule = true) {
		// Existiert bereits eine Modul-Hauptinstanz?
		if(self::existMainInstance()) throw new \Exception('Es existiert bereits eine Modul-Hauptinstanz.', 1011);
			
		// Die Hauptinstanz setzen
		self::setMainInstance($this);
		
		// Standard-Template-Set aktivieren
		$this->setTemplateSet('main');
	
		// Welches Modul wurde angefordert?
		$moduleNameString = isset($_GET[self::GET_NAME]) ? $_GET[self::GET_NAME] : self::START_MODULE;
		
		do {
			// Ein Objekt drausmachen
			$this->moduleName = new Module\Name($moduleNameString);
			
			// Das Module existiert nicht?
			if(!$this->existModule()) {
				// Das Error-Module soll angezeigt werden und wir sind nicht bereits so weit?
				if($showErrorModule && $this->moduleName != self::ERROR_MODULE)
					$moduleNameString = self::ERROR_MODULE;
				else // Das Error-Module existiert nicht oder es soll direkt eine Exception geworfen werden?
					throw new \Exception('Das angeforderte Modul „'.$this->moduleName.'“ existiert nicht.', 1010);
			}
		} while(!$this->existModule()); // Das Module existiert nicht? Dann mach das da oben nochmal!
	}
	
	/**
	* Öffnet das Modul. (Lädt alle Klassen und stellt die Templates da.)
	**/
	public function open() {
		// Alle System-Variablen setzen
		$this->setSystemCacheVars();
		
		// Alle Klassen laden
		$this->loadAllClasses();
		// Alle Templates darstellen
		$this->showAllTemplates();
	}
	
	/**
	* Exisitert das angeforderte Modul überhaupt?
	*
	* @return bool
	**/
	private function existModule() {
		// Pfad zur Hauptdatei basteln
		$moduleClassFile = ROOT_PATH.self::MODULE_DIR.$this->moduleName->getPathToFile();
		// Existiert diese Datei?
		return file_exists($moduleClassFile);
	}
	
	/**
	* Gibt die Module-Name-Klasse zurück.
	*
	* @return \Core\Module\Name
	**/
	public function getModuleName() {
		return $this->moduleName;
	}
	
	/**
	* Setzt das Template-Set. Standard-Set ist "main".
	* 
	* @param String $name - Name des Template-Set
	**/
	public function setTemplateSet($name) {
		if (!(file_exists(ROOT_PATH.self::SET_DIR.$name.'Head.tpl.php') && file_exists(ROOT_PATH.self::SET_DIR.$name.'Foot.tpl.php')))
			throw new \Exception('Das angeforderte Template-Set „'.$name.'“ existiert nicht oder nicht vollständig.', 1012);
			
		$this->templateSet = $name;
	}
	
	/**
	* Setzt die System-CacheVars.
	**/
	private function setSystemCacheVars() {
		// Den aktuellen Modul-Namen setzen
		$this->addVarCache('currentModule',$this->moduleName);
		
		// Die mitgesendeten Optionen setzen
		$this->addVarCache('options',isset($_GET[self::GET_OPTIONS]) ? $_GET[self::GET_OPTIONS] : array());
	}
	
	/**
	* Gibt zurück, welche Haupt-Elemnte vorhanden sind
	*
	* @param string $type - Welcher Typ?
	* @return array
	**/
	private function getMainArray($type) {
		// Den aktuellen Namen
		$moduleName = $this->moduleName;
		// Main-Class sammeln
		$mainElements = array();
		
		do {
			// Den Pfad zur Haupt-Klasse bilden
			$mainPath = self::MODULE_DIR.$moduleName->getPathToFile($type,true);
			// Die Klasse existiert nicht? Weiter!
			if(!file_exists(ROOT_PATH.$mainPath)) continue;
			
			// Dem Array hinzufügen
			$mainElements[] = $moduleName;
		// Den Block so lange wiederholen, bis wir am Ende angekommen sind
		} while($moduleName = $moduleName->getParentSegmentsAsObject());
		
		// Das Array umsortieren
		krsort($mainElements);
		
		return $mainElements;
	}
	
	/**
	* Lädt alle Modul-Klassen
	**/
	private function loadAllClasses() {
		// Hier noch Haupt-Klassen einfügen
		$this->loadMainClasses();
	
		// Pfad zur Klassen-Datei basteln
		$moduleClassFile = self::MODULE_DIR.$this->moduleName->getPathToFile();
		// Sie einbinden
		new Module\Script($moduleClassFile);
	}
	
	/**
	* Lädt die Hauptklassen.
	**/
	private function loadMainClasses() {
		$mainClasses = $this->getMainArray('script');
		
		// Das Array durchgehen
		foreach($mainClasses as $currentName) {
			// Pfad zum Template
			$scriptPath = self::MODULE_DIR.$currentName->getPathToFile('script',true);
			
			// Template einbinden
			new Module\Script($scriptPath);
		}
	}
	
	/**
	* Stellt alle Templates da
	**/
	private function showAllTemplates() {
		// Den Pfad zu dem Template basteln
		$moduleTemplateFile = self::MODULE_DIR.$this->moduleName->getPathToFile('template');
		// Wenn diese Datei nicht existiert, dann hat das Module keine Templates
		if(!file_exists(ROOT_PATH.$moduleTemplateFile)) return;
	
		// Der Pfad zu dem Template-Set basteln
		$templateSetPath = self::SET_DIR.$this->templateSet;
		
		// Den Header einbinden
		new Module\Template($templateSetPath.'Head.tpl.php');
		
		// Haupt-Templates hier einfügen
		$this->showMainTemplates();
		
		// Das Modul-Template einfügen
		new Module\Template($moduleTemplateFile);
		
		// Den Footer einbinden
		new Module\Template($templateSetPath.'Foot.tpl.php');		
	}
	
	/**
	* Lädt die Hauptklassen.
	**/
	private function showMainTemplates() {
		$mainTemplates = $this->getMainArray('template');
		
		// Das Array durchgehen
		foreach($mainTemplates as $currentName) {
			// Pfad zum Template
			$templatePath = self::MODULE_DIR.$currentName->getPathToFile('template',true);
			
			// Template einbinden
			new Module\Template($templatePath);
		}
	}
	
	/**
	* Fügt ein Template ein.
	*
	* @param string $templateName - Name des Templates
	* @param array $vars - Variablen
	**/
	public function includeTemplate($templateName, array $vars) {
		// Pfad fertig basteln
		$templatePath = self::INC_DIR.$templateName.'.tpl.php';
	
		// Template einfügen
		new Module\Template($templatePath, $vars);
	}
	
	/**
	* Gibt den Inhalt eines Templates zurück.
	*
	* @param string $templateName - Name des Templates
	* @param array $vars - Variablen
	**/
	public function getTemplateContent($templateName, array $vars) {
		ob_start();
		$this->includeTemplate($templateName, $vars);
		
		// Inhalt bekommen
		$content = ob_get_clean();
		
		// Inhalt vereinfachen
		$content = trim($content);
		$content = str_replace("\n", ' ', $content);
		
		// Output-Buffer zurückgeben
		return $content;
	}
	
	/**
	* Leitet zu einem Modul um
	*
	* @param String $moduleName - Der Name das zu verlinkenden Moduls [optional]
	* @param Array $options - Die mitgelieferten Optionen [optional]
	* @param string $anchor - HTML-Anker [optional]
	**/
	public static function goToModule($moduleName = '', array $options = array(), $anchor = NULL) {
		i::Header()->addLocation(self::createModuleLink($moduleName, $options, $anchor, false));
	}
	
	
	/**
	* Erzeugt einen Link zu einem Modul.
	*
	* @param String $moduleName - Der Name das zu verlinkenden Moduls [optional]
	* @param Array $options - Die mitgelieferten Optionen [optional]
	* @param string $anchor - HTML-Anker [optional]
	* @param bool $encodeEntities - Später als in HTML? [optional]
	* @return String - Der Link zu dem Modul
	**/
	public static function createModuleLink($moduleName = NULL, array $options = array(), $anchor = NULL, $encodeEntities = true) {
		// Wenn der angeforderte Name NULL ist, auf das eigene Verweisen
		if(is_null($moduleName)) $moduleName = i::Module()->moduleName;
	
		// Der Modul-Name die URL einfügen
		$url = 'index.php?'.self::GET_NAME.'='.$moduleName;
		// Die gewünschten Optionen mitschicken
		$url .= self::getMoreParamsForLink('&'.self::GET_OPTIONS,$options);
		// Noch ein Anker?
		$url .= ($anchor!=NULL ? '#'.$anchor : '');
		// Sollen die Entities noch maskiert werden?
		if($encodeEntities) $url = htmlentities($url);
		
		// Ergebnis zurückgeben
		return $url;
    }
    
    /**
    * Reine Hilfs-Methode für createModuleLink()
    **/
    private static function getMoreParamsForLink($keyString, $value) {
    	$string = '';
	    if(is_array($value)) {
	    	foreach($value as $valueKey => $valueCurrent)
	    	$string .= self::getMoreParamsForLink($keyString.'['.urlencode($valueKey).']',$valueCurrent);
	    } else
	    	$string .= $keyString.'='.urlencode($value);
	    
	    return $string;
    }
}
?>