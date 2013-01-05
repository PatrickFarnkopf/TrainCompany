<?php
/**
*
* Einer Übersicht über alle Ausschreibungen für den Spieler.
* Datum: 16. November 2012
*
**/
script {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Ausschreibungen');
		
		$taskManager = \Game\Task\i::Manager();
		$taskManager->loadAll();
		$this->mi()->addVarCache('taskList', $taskManager->listObjects());
		
		try {
			if(isset($options['currentTask']) && $options['currentTask'] == 'invalid')
				throw new \HumanException('Die ausgewählte Ausschreibung existiert nicht oder nicht mehr.', -1);
			if(isset($options['currentTaskApplicaton']) && $options['currentTaskApplicaton'] == 'invalid')	
				throw new \HumanException('Deine Bewerbung ist ungültig. Versuche es nochmal!', -2);
			
			if(isset($options['addApplication']) && $options['addApplication'] == 'success') {
				$this->mi()->addVarCache('showSuccess', true);
				$this->mi()->addVarCache('successString', 'Die Bewerbung wurde erfolgreich eingereicht. Dein Zug wird losgeschickt, sobald du die Ausschreibung gewonnen hast.');
			}
		
			if(isset($options['makeAction']) && $options['makeAction']) $this->startApplication();	
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
	}
	
	/**
	* Schaut welche Ausschreibung ausgewählt wurde und leitet dann zum Entsprechenden „Bewerbungs“-Formular weiter.
	**/
	private function startApplication() {
		$taskManager = \Game\Task\i::Manager();
	
		$applicationArray = isset($_POST['takeTask']) && is_array($_POST['takeTask']) ? $_POST['takeTask'] : [];
		$applicationIDs = array_keys($applicationArray);
		
		if(!isset($applicationIDs[0]))
			throw new \HumanException('Du musst eine Ausschreibung auswählen.', -1);
		$taskID = $applicationIDs[0];
		
		if(!$taskManager->existObjectForID($taskID))
			throw new \HumanException('Diese Ausschreibung existiert nicht oder nicht mehr.', -2);
		$task = $taskManager->getObjectForID($taskID);
		
		if($task->getType() == \Game\TASK::WITH_APPLICATION && $task->existApplicationForUser($this->ui()))
			throw new \HumanException('Du hast dich für diese Ausschreibung bereits beworben.', -3);
		
		$taskApplication = new \Game\Task\Application();
		$this->si()->addElementToVarCache('taskApplications',$taskApplication, $taskID);
		
		\Core\Module::goToModule('Game_Trains_Select',['taskID'=>$taskID]);
	}
}