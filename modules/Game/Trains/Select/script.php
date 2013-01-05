<?php
/**
*
* Zeigt alle Züge an, die mit dieser Ausschreibung kompatibel sind.
* Datum: 1. Dezember 2012
*
**/
script {
	private $taskID = false;
	private $task = false;
	private $taskApplication = false;
	
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Fahrzeug auswählen');
		
		$taskManager = \Game\Task\i::Manager();
		$taskManager->loadAll();
		
		// Ausschreibung laden
		$this->taskID = isset($options['taskID']) ? $options['taskID'] : -1;
		$this->task = $taskManager->existObjectForID($this->taskID) ? $taskManager->getObjectForID($this->taskID) : false;
		
		// Bewerbung laden
		$taskApplicationList = $this->si()->issetVarCache('taskApplications') ? $this->si()->getVarCache('taskApplications') : [];
		$this->taskApplication = isset($taskApplicationList[$this->taskID]) ? $taskApplicationList[$this->taskID] : false;
		
		// Bewerbung überprüfen
		$this->checkApplication();
		
		// Eventuelle Auswahlen, die in der Bewerbung schon vorhanden sind, übernehmen
		if($this->taskApplication->getTrainUnitID() != -1)
			$this->mi()->addVarCache('selectedUnit', $this->taskApplication->getTrainUnitID());
		
		// Aufgaben dieses Modules ausführen
		$this->mi()->addVarCache('task', $this->task);
		$this->mi()->addVarCache('taskID', $this->taskID);
		
		$trainUnitGroups = $this->ui()->listTrainUnitGroups();
		$this->mi()->addVarCache('trainUnitGroups', $trainUnitGroups);
		
		// Die Zugeinheiten speichern
		$trainUnits = [];
		foreach($trainUnitGroups as $groupID => $currentGroup)
			$trainUnits[$groupID] = $this->ui()->listTrainUnits($groupID);
		$this->mi()->addVarCache('trainUnits', $trainUnits);
		
		try {
			if(isset($options['makeAction']) && $options['makeAction']) {
				if(isset($_POST['back'])) $this->cancelApplication();
				else if(isset($_POST['select'])) $this->selectTrainUnit();
			}
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
		
	}
	
	/**
	* Überprüft die Bewerbung
	**/
	private function checkApplication() {
		// Die Ausschreibung nicht (mehr) vorhanden?
		if($this->task === false)
			\Core\Module::goToModule('Game_Tasks', ['currentTask'=>'invalid']);
	
		try {
			if($this->taskApplication === false)
				throw new \HumanException();
		} catch (\HumanException $exception) {
			\Core\Module::goToModule('Game_Tasks', ['currentTaskApplicaton'=>'invalid']);
		}
	}
	
	/**
	* Löscht die aktuelle Bewerbung und springt zurück in die Ausschreibungs-Übersicht
	**/
	private function cancelApplication() {
		$this->si()->unsetElementInVarCache('taskApplications',$this->taskID);
		\Core\Module::goToModule('Game_Tasks');
	}
	
	/**
	* Überprüft die Auswahl und leitet eventuell weiter zu Strecken-Auswahl
	**/
	private function selectTrainUnit() {
		$userTrainUnits = $this->ui()->listTrainUnits();
		$selectedTrainUnitID = isset($_POST['trainUnit']) ? $_POST['trainUnit'] : false;
		
		if($selectedTrainUnitID === false)
			throw new HumanException('Keine Zugeinheit ausgewählt. Bitte wähle zuerst eine Zugeinheit aus.', -1);
		else if(!isset($userTrainUnits[$selectedTrainUnitID]))
			throw new HumanException('Ungültige Zugeinheiten ausgewählt. Bitte versuch’ es erneut!', -2);
		
		$selectedTrainUnit = $userTrainUnits[$selectedTrainUnitID];
		if(!$this->task->isCompatibleTrainUnit($selectedTrainUnit))
			throw new HumanException('Diese Zugeinheit passt nicht zu der Ausschreibung.', -3);
		
		$this->taskApplication->setTrainUnitID($selectedTrainUnitID);		
		\Core\Module::goToModule('Game_Map_Select',['taskID'=>$this->taskID]);
	}
}
?>