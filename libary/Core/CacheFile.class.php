<?php
/**
*
* Eine Möglichkeit, Daten in einer Datei zu Cachen.
* Datum: 12. November 2012
*
**/
namespace Core;

class CacheFile extends Cache {
	use Cache\Vars;

	const DIR = 'cache/';
	const DONT_DELETE_FILE = '.dontDelete';
	
    private $fileName;
    private $cache = array();

    /**
    * Öffnet eine Cache-Datei mit entsprechenden Namen. Wenn sie bereits vorhanden ist, wird der Inhalt geladen.
    *
    * @param string $fileName - Name der Datei
    **/
    public function __construct($fileName) {
    	if (static::existInstanceFor($fileName)) throw new \Exception('Es ist bereits eine Instanz für diesen Cache-File vorhanden.', 1040);
    
    	static::$instances[$fileName] = $this;
	    
    	$this->fileName = $fileName;
		$this->loadFile();
    }
        
    /**
    * Beim schließen des Objekts die Daten schreiben
    **/
    public function __destruct() {
	    $this->writeFile();
	    
	    unset(static::$instances[$this->fileName]);
    }
    
    /**
    * Setzt eine Variable in den Cache
    *
    * @param string $name - Name der Variable
    * @param mixed $content - Inhalt der Variable
    **/
    public function setVar($name, $content) {
	    $this->cache[$name] = $content;
    }
    
    /**
    * Gibt die Variable aus dem Cache zurück.
    *
    * @param string $name - Name der Variable
    * @return mixed - Inhalt der Variable
    **/
    public function getVar($name) {
	    if(!isset($this->cache[$name])) throw new \Exception('Die Variable „'.$name.'“ liegt nicht in diesem Cache-File.', 1041); 
	    
	    return $this->cache[$name];
    }
    
    /**
    * Gibt zurück, ob die Variable im Variablen-Cache liegt.
    *
    * @param string $name - Name der Variable
    * @return bool - Ist im Cache?
    **/
    public function issetVar($name) {
	    return isset($this->cache[$name]);
    }
    
    /**
    * Gibt alle Daten zurück, die in diese Cache-Datei geschrieben sind.
    *
    * @return array[mixed] - Alle Cach-Daten
    **/
    public function getAll() {
	    return $this->cache;
    }
    
    /**
    * Gibt den ganzen Namen der Cache-Datei aus.
    *
    * @return String - Der ganze Namen der Datei
    **/
    private function getFullFileName() {
	    return ROOT_PATH.'/'.static::DIR.$this->fileName.'.cache';
    }
    
    /**
    * Versucht eine Datei mit entsprechenden Namen zu laden.
    **/
    private function loadFile() {
	    if(!file_exists($this->getFullFileName())) return;
	    
	    $fileContent = file_get_contents($this->getFullFileName());
	    $this->cache = unserialize($fileContent);
    }
    
    /**
    * Schreibt die Datei mit entsprechenden Namen.
    **/
    private function writeFile() {
	    $fileContent = serialize($this->cache);
	    file_put_contents($this->getFullFileName(), $fileContent);
    }
    
    /**
    * Gibt ein Array mit Informationen über den Cache-Ordner zurück.
    *
    * @param $dir - Unterordner? [optional]
    * @return array - Informationen
    **/
    public static function getInfo($dir='') {
    	// Arrays erstellen
    	$infoArray = array();
	    $infoArray['elementCount'] = 0;
	    $infoArray['size'] = 0;
    
	    // Ordner-Name ermitteln
    	$dirName = ROOT_PATH.'/'.static::DIR.$dir;
	    foreach(scandir($dirName) as $currentFile) {
		    if($currentFile == '..' || $currentFile == '.' || $currentFile == self::DONT_DELETE_FILE) continue;
		    
		    // Wenn Ordner, dann diesen rekursiv durchsuchen
		    if(is_dir($dirName.$currentFile)) {
			    $info = self::getInfo($dir.$currentFile.'/');
			    
			    $infoArray['elementCount'] += $info['elementCount'];
			    $infoArray['size'] += $info['size'];
		    } else {
			    $infoArray['elementCount'] ++;
			    $infoArray['size'] += filesize($dirName.$currentFile);
		    }
	    }
	    
	    return $infoArray;
    }
    
    /**
    * Löscht den Cache komplett
    *
    * @param $dir - Unterordner? [optional]
    **/
    public static function clearCache($dir='') {
    	$dirName = ROOT_PATH.'/'.static::DIR.$dir;
	    foreach(scandir($dirName) as $currentFile) {
		    if($currentFile == '..' || $currentFile == '.' || $currentFile == self::DONT_DELETE_FILE) continue;
		    
		    // Wenn Ordner, dann erst den lehren und danach siche selbst löschen
		    if(is_dir($dirName.$currentFile)) {
			    self::clearCache($dir.$currentFile.'/');
			    // Ordner löschen
			    rmdir($dirName.$currentFile);
		    } else
		    	unlink($dirName.$currentFile);
	    }
    }
}
?>