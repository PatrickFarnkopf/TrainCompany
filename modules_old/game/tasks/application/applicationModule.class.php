<?php
if(!defined('INC')) exit;
/**
*
* Übersicht über die Bewerbung
* Datum: 3. Dezember 2012
*
**/
class applicationModule {
	private $taskID = false;
	private $task = false;
	private $taskApplication = false;

	private $taskSchedule = false;

	public function __construct() {
		$options = cmi()->getVarCache('options');
		cmi()->addVarCache('siteTitle', 'Fahrplan festlegen');
		$taskManager = i::TaskManager();
		$taskManager->loadAll();
		
		// Ausschreibung laden
		$this->taskID = isset($options['taskID']) ? $options['taskID'] : -1;
		$this->task = $taskManager->existObjectForID($this->taskID) ? $taskManager->getObjectForID($this->taskID) : false;
		
		// Bewerbung laden
		$taskApplicationList = lsi()->issetVarCache('taskApplications') ? lsi()->getVarCache('taskApplications') : array();
		$this->taskApplication = isset($taskApplicationList[$this->taskID]) ? $taskApplicationList[$this->taskID] : false;
		
		// Bewerbung überprüfen
		$this->checkApplication();
			
		// Eventuelle Auswahlen, die in der Bewerbung schon vorhanden sind, übernehmen
		if(is_object($this->taskApplication->getTaskSchedule())) {
			$this->taskSchedule = $this->taskApplication->getTaskSchedule();
		} else
			$this->taskSchedule = new TaskSchedule();
		
		// Aufgaben dieses Modules ausführen
		cmi()->addVarCache('task', $this->task);
		cmi()->addVarCache('taskID', $this->taskID);
		cmi()->addVarCache('neededStations', $this->task->getStations());
		cmi()->addVarCache('stations', $this->taskApplication->getPathUnit()->getStations());
		
		// Ankunfszeiten berechnen
		$arrivalTimesEmpty = $this->taskApplication->getPathUnit()->calcTimeWithTrainUnit($this->taskApplication->getTrainUnit(lsi()->getUserInstance()), TrainUnit::EMPTY_WEIGHT, $this->task->getStations());
		$arrivalTimesMax = $this->taskApplication->getPathUnit()->calcTimeWithTrainUnit($this->taskApplication->getTrainUnit(lsi()->getUserInstance()), TrainUnit::MAX_WEIGHT, $this->task->getStations());
		cmi()->addVarCache('arrivalTimes',array('empty'=>$arrivalTimesEmpty,'max'=>$arrivalTimesMax));
		
		try {
			if(isset($options['makeAction']) && $options['makeAction']) { 
				if(isset($_POST['back'])) Module::goToModule('game_map_select',array('taskID'=>$this->taskID));
				else $this->getSchedule();
			}
		} catch(HumanException $exception) {
			cmi()->addVarCache('showError', true);
			cmi()->addVarCache('errorString', $exception->getMessage());
		}
		
		cmi()->addVarCache('taskSchedule', $this->taskSchedule);
	}
	
	/**
	* Überprüft die Bewerbung
	**/
	private function checkApplication() {
		// Die Ausschreibung nicht (mehr) vorhanden?
		if($this->task === false)
			Module::goToModule('game_tasks', array('currentTask'=>'invalid'));
		
		try {
			if($this->taskApplication === false)
				throw new HumanException('Die Bewerbung ist ungültig.', -1);
		
			$this->taskApplication->checkTrainUnit($this->task, lsi()->getUserInstance());
			$this->taskApplication->checkPathUnit($this->task, lsi()->getUserInstance());
		} catch (HumanException $exception) {
			Module::goToModule('game_tasks', array('currentTaskApplicaton'=>'invalid'));
		}
	}
	
	/**
	* Lädt den Fahrplan aus dem Formular und macht einen Fahrplan draus.
	**/
	private function getSchedule() {
		$this->taskSchedule = new TaskSchedule();
		
		foreach($this->task->getStations() as $currentStation) {
			$arrivalArray = isset($_POST[$currentStation->getID()]['arrival']) ? $_POST[$currentStation->getID()]['arrival'] : array();
			$arrivalTime = self::getTimeFromArray($arrivalArray);
			
			$departureArray = isset($_POST[$currentStation->getID()]['departure']) ? $_POST[$currentStation->getID()]['departure'] : array();
			$departureTime = self::getTimeFromArray($departureArray);
			
			$this->taskSchedule->addStation($currentStation, $arrivalTime, $departureTime);
		}
		
		$this->taskApplication->setTaskSchedule($this->taskSchedule);
		$this->taskSchedule->check();
		
		// Zugeinheit sperren
		$this->taskApplication->getTrainUnit(i::Session()->getUserInstance())->lock();
		if($this->task->getType() == Task::WITH_APPLICATION) {
			$this->task->addApplication($this->taskApplication, i::Session()->getUserInstance());
			
			Module::goToModule('game_tasks', array('addApplication'=>'success'));
		} else {
			$this->task->removeAllApplications();
		
			$userInstance = i::Session()->getUserInstance();
			$taskJourneyManager = i::TaskJourneyManager($userInstance->getUserID());
		
			$taskJourney = new TaskJourney(lsi()->getUserInstance(), $this->task, $this->taskApplication);
			$taskJourneyManager->addObject($taskJourney);
			
			// Die Aufgabe aus der Liste löschen
			i::TaskManager()->removeObject($this->taskID);
		
			Module::goToModule('game_tasks_active', array('application'=>'success'));
		}
	}
	
	/**
	* Gibt die Zeit von einem Zeit-Array zurück.
	*
	* @param array $timeArray
	* @return Time - Zeit in Sekunden
	**/
	
	private static function getTimeFromArray(array $array) {
		if(!isset($array[60]) || !is_numeric($array[60])) $array[60] = 0;
		if(!isset($array[1]) || !is_numeric($array[1])) $array[1] = 0;
		
		return Time::withHoursAndMinutes($array[60],$array[1]);
	}
}
?>