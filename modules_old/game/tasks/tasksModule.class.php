<?php
if(!defined('INC')) exit;
/**
*
* Einer Übersicht über alle Ausschreibungen für den Spieler.
* Datum: 16. November 2012
*
**/
class tasksModule {
	public function __construct() {
		$options = cmi()->getVarCache('options');
		cmi()->addVarCache('siteTitle', 'Ausschreibungen');
		
		$taskManager = i::TaskManager();
		$taskManager->loadAll();
		cmi()->addVarCache('taskList', $taskManager->listObjects());
		
		try {
			if(isset($options['currentTask']) && $options['currentTask'] == 'invalid')
				throw new HumanException('Die ausgewählte Ausschreibung existiert nicht oder nicht mehr.', -1);
			if(isset($options['currentTaskApplicaton']) && $options['currentTaskApplicaton'] == 'invalid')	
				throw new HumanException('Deine Bewerbung ist ungültig. Versuche es nochmal!', -2);
			
			if(isset($options['addApplication']) && $options['addApplication'] == 'success') {
				cmi()->addVarCache('showSuccess', true);
				cmi()->addVarCache('successString', 'Die Bewerbung wurde erfolgreich eingereicht. Dein Zug wird losgeschickt, sobald du die Ausschreibung gewonnen hast.');
			}
		
			if(isset($options['makeAction']) && $options['makeAction']) $this->startApplication();	
		} catch(HumanException $exception) {
			cmi()->addVarCache('showError', true);
			cmi()->addVarCache('errorString', $exception->getMessage());
		}
	}
	
	/**
	* Schaut welche Ausschreibung ausgewählt wurde und leitet dann zum Entsprechenden „Bewerbungs“-Formular weiter.
	**/
	private function startApplication() {
		$applicationArray = isset($_POST['takeTask']) && is_array($_POST['takeTask']) ? $_POST['takeTask'] : array();
		$applicationIDs = array_keys($applicationArray);
		
		if(!isset($applicationIDs[0]))
			throw new HumanException('Du musst eine Ausschreibung auswählen.', -1);
		$taskID = $applicationIDs[0];
		
		if(!i::TaskManager()->existObjectForID($taskID))
			throw new HumanException('Diese Ausschreibung existiert nicht oder nicht mehr.', -2);
		$task = i::TaskManager()->getObjectForID($taskID);
		
		if($task->getType() == TASK::WITH_APPLICATION && $task->existApplicationForUser(i::Session()->getUserInstance()))
			throw new HumanException('Du hast dich für diese Ausschreibung bereits beworben.', -3);
		
		$taskApplication = new TaskApplication();
		i::Session()->addElementToVarCache('taskApplications',$taskApplication, $taskID);
		
		Module::goToModule('game_trains_select',array('taskID'=>$taskID));
	}
}