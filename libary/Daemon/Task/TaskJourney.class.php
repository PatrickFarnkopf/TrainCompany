<?php	
/**
*
* Erstellt neue Ausschreibung, falsch zu wenig vorhanden sind.
* Datum: 4. Dezember 2012
*
**/
namespace Daemon\Task;

class TaskJourney implements \Daemon\Task {
	private $hasToRun = false;

	/**
	* Überprüft, ob die Aufgabe ausgeführt werden muss
	**/
	public function __construct() {
		i::\Game\Task\Journey\Manager()->loadActionNeeded();
		
		if (i::\Game\Task\Journey\Manager()->countObjects() > 0)
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
		foreach(i::\Game\Task\Journey\Manager()->listObjects() as $taskJourneyID => $currentTaskJourney) {
			if($currentTaskJourney->getNextStepTime() == 0 || $currentTaskJourney->getNextStepTime() > time()) continue;
			// Wenn ein nächste Aufgabe vorhanden ist, dann führe diese auch aus! 
			if($currentTaskJourney->existNextStep())
				$currentTaskJourney->runNextStep();
			else {// Die Aufgabe ist beendet
				$currentTaskJourney->finishJourney();
				// Ausschreibung aus der Liste löschen
				i::\Game\Task\Journey\Manager()->removeObject($taskJourneyID);
			}
		}
	}
}
?>