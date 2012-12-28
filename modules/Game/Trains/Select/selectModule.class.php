<?php
if(!defined('INC')) exit;
/**
*
* Zeigt alle Züge an, die mit dieser Ausschreibung kompatibel sind.
* Datum: 1. Dezember 2012
*
**/

class selectModule {
	private $taskID = false;
	private $task = false;
	private $taskApplication = false;
	
	public function __construct() {
		$options = cmi()->getVarCache('options');
		cmi()->addVarCache('siteTitle', 'Fahrzeug auswählen');
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
		if($this->taskApplication->getTrainUnitID() != -1)
			cmi()->addVarCache('selectedUnit', $this->taskApplication->getTrainUnitID());
		
		// Aufgaben dieses Modules ausführen
		cmi()->addVarCache('task', $this->task);
		cmi()->addVarCache('taskID', $this->taskID);
		
		$trainUnitGroups = lsi()->getUserInstance()->listTrainUnitGroups();
		cmi()->addVarCache('trainUnitGroups', $trainUnitGroups);
		
		try {
			if(isset($options['makeAction']) && $options['makeAction']) {
				if(isset($_POST['back'])) $this->cancelApplication();
				else if(isset($_POST['select'])) $this->selectTrainUnit();
			}
		} catch(HumanException $exception) {
			cmi()->addVarCache('showError', true);
			cmi()->addVarCache('errorString', $exception->getMessage());
		}
		
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
		} catch (HumanException $exception) {
			Module::goToModule('game_tasks', array('currentTaskApplicaton'=>'invalid'));
		}
	}
	
	/**
	* Löscht die aktuelle Bewerbung und springt zurück in die Ausschreibungs-Übersicht
	**/
	private function cancelApplication() {
		lsi()->unsetElementInVarCache('taskApplications',$this->taskID);
		Module::goToModule('game_tasks');
	}
	
	/**
	* Überprüft die Auswahl und leitet eventuell weiter zu Strecken-Auswahl
	**/
	private function selectTrainUnit() {
		$userTrainUnits = lsi()->getUserInstance()->listTrainUnits();
		$selectedTrainUnitID = isset($_POST['trainUnit']) ? $_POST['trainUnit'] : false;
		
		if($selectedTrainUnitID === false)
			throw new HumanException('Keine Zugeinheit ausgewählt. Bitte wähle zuerst eine Zugeinheit aus.', -1);
		else if(!isset($userTrainUnits[$selectedTrainUnitID]))
			throw new HumanException('Ungültige Zugeinheiten ausgewählt. Bitte versuch’ es erneut!', -2);
		
		$selectedTrainUnit = $userTrainUnits[$selectedTrainUnitID];
		if(!$this->task->isCompatibleTrainUnit($selectedTrainUnit))
			throw new HumanException('Diese Zugeinheit passt nicht zu der Ausschreibung.', -3);
		
		$this->taskApplication->setTrainUnitID($selectedTrainUnitID);		
		Module::goToModule('game_map_select',array('taskID'=>$this->taskID));
	}
}
?>