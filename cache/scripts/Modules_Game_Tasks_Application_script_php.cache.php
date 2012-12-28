<?php
/**
*
* Übersicht über die Bewerbung
* Datum: 3. Dezember 2012
*
**/
namespace Script; class Modules_Game_Tasks_Application_script_php extends \Core\Module\Extender  {
	private $taskID = false;
	private $task = false;
	private $taskApplication = false;

	private $taskSchedule = false;

	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Fahrplan festlegen');
		
		$taskManager = \Game\Task\i::Manager();
		$taskManager->loadAll();
		
		// Ausschreibung laden
		$this->taskID = isset($options['taskID']) ? $options['taskID'] : -1;
		$this->task = $taskManager->existObjectForID($this->taskID) ? $taskManager->getObjectForID($this->taskID) : false;
		
		// Bewerbung laden
		$taskApplicationList = $this->si()->issetVarCache('taskApplications') ? $this->si()->getVarCache('taskApplications') : array();
		$this->taskApplication = isset($taskApplicationList[$this->taskID]) ? $taskApplicationList[$this->taskID] : false;
		
		// Bewerbung überprüfen
		$this->checkApplication();
			
		// Eventuelle Auswahlen, die in der Bewerbung schon vorhanden sind, übernehmen
		if(is_object($this->taskApplication->getTaskSchedule())) {
			$this->taskSchedule = $this->taskApplication->getTaskSchedule();
		} else
			$this->taskSchedule = new \Game\Task\Schedule();
		
		// Aufgaben dieses Modules ausführen
		$this->mi()->addVarCache('task', $this->task);
		$this->mi()->addVarCache('taskID', $this->taskID);
		$this->mi()->addVarCache('neededStations', $this->task->getStations());
		$this->mi()->addVarCache('stations', $this->taskApplication->getPathUnit()->getStations());
		
		// Ankunfszeiten berechnen
		$arrivalTimesEmpty = $this->taskApplication->getPathUnit()->calcTimeWithTrainUnit($this->taskApplication->getTrainUnit($this->ui()), \Game\Train\Unit::EMPTY_WEIGHT, $this->task->getStations());
		$arrivalTimesMax = $this->taskApplication->getPathUnit()->calcTimeWithTrainUnit($this->taskApplication->getTrainUnit($this->ui()), \Game\Train\Unit::MAX_WEIGHT, $this->task->getStations());
		$this->mi()->addVarCache('arrivalTimes',array('empty'=>$arrivalTimesEmpty,'max'=>$arrivalTimesMax));
		
		try {
			if(isset($options['makeAction']) && $options['makeAction']) { 
				if(isset($_POST['back'])) Module::goToModule('game_map_select',array('taskID'=>$this->taskID));
				else $this->getSchedule();
			}
		} catch(HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
		
		$this->mi()->addVarCache('taskSchedule', $this->taskSchedule);
	}
	
	/**
	* Überprüft die Bewerbung
	**/
	private function checkApplication() {
		// Die Ausschreibung nicht (mehr) vorhanden?
		if($this->task === false)
			\Core\Module::goToModule('Game_Tasks', array('currentTask'=>'invalid'));
		
		try {
			if($this->taskApplication === false)
				throw new \HumanException();
		
			$this->taskApplication->checkTrainUnit($this->task, $this->ui());
			$this->taskApplication->checkPathUnit($this->task, $this->ui());
		} catch (\HumanException $exception) {
			\Core\Module::goToModule('Game_Tasks', array('currentTaskApplicaton'=>'invalid'));
		}
	}
	
	/**
	* Lädt den Fahrplan aus dem Formular und macht einen Fahrplan draus.
	**/
	private function getSchedule() {
		$this->taskSchedule = new \Game\Task\Schedule();
		
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
		$this->taskApplication->getTrainUnit($this->ui())->lock();
		if($this->task->getType() == \Game\Task::WITH_APPLICATION) {
			$this->task->addApplication($this->taskApplication, $this->ui());
			
			\Core\Module::goToModule('Game_Tasks', array('addApplication'=>'success'));
		} else {
			$this->task->removeAllApplications();

			$taskJourneyManager = \Game\Task\Journey\i::Manager($this->ui()->getUserID());
		
			$taskJourney = new \Game\Task\Journey($this->ui(), $this->task, $this->taskApplication);
			$taskJourneyManager->addObject($taskJourney);
			
			// Die Aufgabe aus der Liste löschen
			\Game\Task\i::Manager()->removeObject($this->taskID);
		
			\Core\Module::goToModule('Game_Tasks_Active', array('application'=>'success'));
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
		
		return \Core\Time::withHoursAndMinutes($array[60],$array[1]);
	}
}
?>