<?php
/**
*
* Diese Klasse ist die Daemon-Klasse, sie lädt immer die erforderlichen Daten nach,
* um alle anstehnenden Daemon-Aufgaben ausführen zu können.
* Datum: 30. November 2012
*
**/
namespace Daemon;

class Main extends \Game\Main {
	const TASK_DIR = 'lib/daemon/tasks/';
	
	private $taskInstances = array();
	
	/**
	* Den Content-Type auf text/plain setzen
	**/
	public function __construct() {
		parent::__contruct();
		
		\Core\i::Header()->setContentType('text/plain');
		
		if(!\Config\INSTALLED)
			throw new \Exception('TrainCompany muss installiert sein, bevor der Daemon ausgeführt werden kann.', 3010);
	}

	/**
	* „Startet“ die Aufgaben dieser Klasse
	**/
	public function start() {
		// Die Aufgaben im Ordner suchen
		$this->searchTasks();
		
		// Aufgaben ausführen
		foreach($this->taskInstances as $currentTask)
			$this->runTask($currentTask);
			
		// Setzt die letzte Laufzeit
		self::setLastRun();
	}
	
	/**
	* Sucht nach Daemon-Klassen, die ausgeführt werden können.
	**/
	private function searchTasks() {
		$dirName = ROOT_PATH.static::TASK_DIR;
		$taskFiles = array();
	    foreach(scandir($dirName) as $currentFile) {
		    if(!is_file(ROOT_PATH.static::TASK_DIR.$currentFile)) continue;
		    
		    $taskFiles[] = $currentFile;
	    }
	    
	    foreach($taskFiles as $currentFile) {
		    if(!strpos($currentFile, '.class.php')) continue;
		    
		    $taskClass = str_replace('.class.php', '', $currentFile);
		    
		    $reflection = new \ReflectionClass($taskClass);
		    if($reflection->implementsInterface('DaemonTask'))
		    	$this->taskInstances[] = new $taskClass;
	    }
	}
	
	/**
	* Führt eine Aufgabe aus.
	*
	* @param DaemonTask $taskInstance - Name der Klasse
	**/
	private function runTask(Task $taskInstance) {
		if($taskInstance->hasToRun()) {
			try {
				$taskInstance->run();
			} catch(Exception $exception) {
				require_once ROOT_PATH.'tpl/ExceptionPlain.tpl.php';
			}
		}
	}
	
	/**
	* Setzt die letzte Laufzeit
	**/
	private static function setLastRun() {
		$cacheFile = \Core\i::CacheFile('daemon');
		$cacheFile->setVar('lastRun', time());
	}
	
	/**
	* Gibt die letzte Laufzeit zurück
	**/
	public static function getLastRun() {
		$cacheFile = \Core\i::CacheFile('daemon');
		
		if(!$cacheFile->issetVar('lastRun')) return 0;
		return $cacheFile->getVar('lastRun');
	}
}
?>