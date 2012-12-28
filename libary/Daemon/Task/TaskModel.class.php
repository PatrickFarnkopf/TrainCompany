<?php
/**
*
* Erstellt neue Ausschreibung, falsch zu wenig vorhanden sind.
* Datum: 4. Dezember 2012
*
**/
namespace Daemon\Task;

class TaskModel implements \Daemon\Task {
	const MIN_TASKS = 4;
	const CREATE_TASKS = 8;

	private $hasToRun = false;

	/**
	* Überprüft, ob die Aufgabe ausgeführt werden muss
	**/
	public function __construct() {
		if(\Game\TaskModel::countObjects() == 0)
			throw new \Exception('Keine Task-Modelle vorhanden. Diese Daemon-Aufgabe kann nicht durchgeführt werden.', 3000);
	
		if (\Game\Task\i::Manager()->countAllObjects() < self::MIN_TASKS)
			$this->hasToRun = true;
	}

	/**
	* Muss die Aufgabe ausgeführt werden?
	*
	* @return bool - Ja/Nein?
	**/
	public function hasToRun() {
		return $this->hasToRun;
	}
	
	/**
	* Führt die Aufgabe durch
	**/
	public function run() {
		$taskManager = \Game\Task\i::Manager();
		
		for($i = $taskManager->countAllObjects(); $i < self::CREATE_TASKS; $i++) {
			$taskModelID = mt_rand(0, TaskModel::countObjects()-1);
			$taskModel = TaskModel::getObjectForID($taskModelID);
			$taskModel->swapDirection();
			
			$task = new \Game\Task($taskModel->getName(), $taskModel->getDescription(), $taskModel->getPlops(), $taskModel->getGroup());
			$task->setNeededCapacity($taskModel->getNeededCapacity());
			$task->setStations($taskModel->getStations());
			
			$taskManager->addObject($task);
		}
	}
}
?>