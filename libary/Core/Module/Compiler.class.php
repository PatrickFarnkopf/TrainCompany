<?php
/**
*
* Diese Klasse ist das Grundgerüst einer Compiler-Klasse
* Datum: 27.12.2012
*
**/
namespace Core\Module;

abstract class Compiler {
	protected $fileName;
	
	/**
	* Nimmt den Namen der zu komplimierenden Datei entgegen und führt sie aus.
	*
	* @param string $fileName - Zum ROOT_PATH relativer Pfad zur Datei
	* @param array $vars - Variablen die dem Template mitgegeben werden sollen. [optional]
	**/
	public function __construct($fileName, array $vars = array()) {
		// Name der Datei zwischen speichern
		$this->fileName = $fileName;
	
		// Muss eventuell das Cache-Verzeichnis erstellt werden?
		$this->createCacheDir();
		
		// Existiert die Datei überhaupt? Wenn nicht direkt eine Ausnahme werfen!
		if(!file_exists(ROOT_PATH.$this->getFileName()))
			throw new \Exception('Die angegebene Datei „'.$filename.'“ existiert nicht.', 1120);
			
		// Muss die Datei neu kompiliert werden? Wenn ja, dann mach das auch!
		if($this->needRecompile()) $this->recompile();
	}
	
	/**
	* Erstellt den benötigten Ordner, falls dieser nicht vorhanden ist.
	*
	* @return bool - Der Ordner musste erstellt werden?
	**/
	protected function createCacheDir() {
		// Der Ordner existiert bereits? Dann müssen wir ihn auch nicht erstellen.
		if(file_exists(ROOT_PATH.static::CACHE_DIR)) return false;
		
		// Ordner erstellen und bei einem Fehler eine Exception werfen.
		if(!mkdir(ROOT_PATH.static::CACHE_DIR))
			throw new \Exception('Das benötigte Cache-Verzeichnis für die Datei konnte nicht erstellt werden.', 1121);
		
		return true;
	}
	
	/**
	* Gibt den simplen Cache-Namen zurück.
	*
	* @return string
	**/
	protected function getCacheName() {
		// . und / ersetzen durch _
		$name = str_replace('/', '_', $this->getFileName());
		$name = str_replace('.', '_', $name);
		
		return $name;
	}
	
	/**
	* Gibt den Pfad im Cache-Verzeichnis zurück.
	*
	* @return string
	**/
	protected function getCacheFileName() {
		// Verzeichnis davor setzen
		$cacheFile = static::CACHE_DIR;		
		// „/“ durch „_“ resetzen
		$cacheFile .= $this->getCacheName();
		// Endung hinzufügen
		$cacheFile .= '.cache.php';
	
		return $cacheFile;
	}
	
	/**
	* Gibt zurück, ob die Datei neu kompiliert werden muss.
	*
	* @return bool
	**/
	protected function needRecompile() {
		// Dateinamen ermitteln.
		$cacheFile = ROOT_PATH.$this->getCacheFileName();
		$currentFile = ROOT_PATH.$this->getFileName();
	
		// Wenn kein Cache-File existiert muss auf jeden Fall eine neuer gemacht werden.
		if(!file_exists($cacheFile)) return true;
		
		// Letzte Änderungszeiten der Dateien ermitteln
		$cacheFileTime = filemtime($cacheFile);
		$currentFileTime = filemtime($currentFile);
		
		// Die Cache-Datei ist älter als das Template? Neu kompilieren!
		if($currentFileTime > $cacheFileTime) return true;
		
		return false;
	}
	
	/**
	* Gibt den Dateinamen zurück.
	*
	* @return string
	**/
	protected function getFileName() {
		return $this->fileName;
	}
	
	/**
	* Eigentliche Haupt-Methode dieser Klasse. Kompiliert das Template.
	**/
	abstract protected function recompile();
}
?>