<?php
/**
*
* Arbeitet Ausschreibungen ab, die vorbei sind.
* Datum: 12. Dezember 2012
*
**/
namespace Daemon\Task;

class ExpiredTasks implements \Daemon\Task {
	private $hasToRun = false;

	/**
	* Überprüft, ob die Aufgabe ausgeführt werden muss
	**/
	public function __construct() {
		i::\Game\Task\Manager()->loadExpired();
		
		if (i::\Game\Task\Manager()->countObjects() > 0)
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
		foreach(i::\Game\Task\Manager()->listObjects() as $taskID => $currentTask) {
			if($currentTask->getEndTime() == 0 || $currentTask->getEndTime() > time()) continue;
			
			if($currentTask->countApplications() == 0)
				$currentTask->setEndTime(0);
			else {
				// Beste Bewerbung ermitteln
				$bestApplicationAndUser = $currentTask->getBestApplicationAndUser();
				
				// User und Bewerbung fetchen
				$userInstance = $bestApplicationAndUser['user'];
				$taskApplication = $bestApplicationAndUser['application'];
				
				// Alle anderen Zugeinheiten entsperren
				foreach($currentTask->getApplications() as $userID => $currentApplication) {
					if($currentApplication == $taskApplication) continue;
					
					$lostUserInstance = i::\Game\User($userID);
					$currentApplication->getTrainUnit($lostUserInstance)->unlock();
					
					// Notification senden
					$notification = new \Game\Notification('Ausschreibung verloren', 'Du hast die Ausschreibung „'.$currentTask->getTitle().'“ verloren.');
					$lostUserInstance->addNotification($notification);
				}
				
				// Notification senden
				$notification = new \Game\Notification('Ausschreibung gewonnen', 'Du hast die Ausschreibung „'.$currentTask->getTitle().'“ für dich gewonnen.');
				$userInstance->addNotification($notification);
				
				// Alle Bewerbungen aus der Ausschreibung löschen (brauchen wir nicht mehr)
				$currentTask->removeAllApplications();
			
				$taskJourneyManager = i::\Game\Task\Journey\Manager($userInstance->getUserID());
		
				$taskJourney = new \Game\Task\Journey($userInstance, $currentTask, $taskApplication);
				$taskJourneyManager->addObject($taskJourney);
			
				// Die Aufgabe aus der Liste löschen
				i::TaskManager()->removeObject($taskID);
			}
		}
	}
}
?>