<?php
/**
*
* Oberfläche für DEBUG-Informationen
* Datum: 5. November 2012
*
**/
script {
	public function __construct() {
		if(!\Config\DEBUG) \Core\Module::goToModule('Game_Settings');
		
		$options = $this->mi()->getVarCache('options');
		
		if (isset($options['clearCache']) && $options['clearCache'] == true) $this->clearCache();
		$this->mi()->addVarCache('cacheInfo', \Core\CacheFile::getInfo());
		
		$this->mi()->addVarCache('lastDaemon', \Daemon\Main::getLastRun());
		
		if(isset($options['plops'])) $this->changePlops($options['plops']);
		if(isset($options['notification']) && $options['notification'] == 'new') $this->newNotification();
		if(isset($options['tasks']) && $options['tasks'] == 'new') $this->newTasks();
		if(isset($options['trainUnits']) && $options['trainUnits'] == 'unlock') $this->unlockAllTrainUnits();
		if(isset($options['applications']) && $options['applications'] == 'revoke') $this->revokeApplications();
		if(isset($options['tasks']) && $options['tasks'] == 'removeAll') $this->removeAllTasks();
	}
	
	/**
	* Leert den Cache.
	**/
	private function clearCache() {
		\Core\CacheFile::clearCache();

		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', "Der Cache wurde erfolgreich geleert.");
	}
	
	/**
	* Ändert das Geld des Users. (DEBUG-Funktion)
	**/
	private function changePlops($action) {
		switch($action) {
			case 'add':
				\Core\i::Session()->getUserInstance()->addPlops(500000);
				break;
			case 'sub':
				\Core\i::Session()->getUserInstance()->subPlops(500000);
				break;
		}
	}
	
	/**
	* Fügt eine neue Test-Benachrichtigung dem User hinzu (DEBUG-Funktion)
	**/
	private function newNotification() {
		$sampleNotifications = array();
		$sampleNotifications[] = array('title'=>'Zug explodiert','text'=>'Einer deiner Züge ist explodiert, er musste ersetzt werden.','moneySub'=>100000, 'moneyAdd'=>0);
		$sampleNotifications[] = array('title'=>'Zug verspätet','text'=>'Ein betrunkener Fahrgast randaliert. Dein Zug hat jetzt 10 Minuten Verspätung.','moneySub'=>5000, 'moneyAdd'=>0);
		$sampleNotifications[] = array('title'=>'Zug angekommen','text'=>'Dein Zug ist in Köln Hbf angekommen.','moneySub'=>0, 'moneyAdd'=>35000);
		$sampleNotifications[] = array('title'=>'Kein Geld','text'=>'Dein Konto ist leer. Du kannst keine weiteren Aktionen durchführen.','moneySub'=>0, 'moneyAdd'=>0);
		
		$notificationID = mt_rand(0,count($sampleNotifications)-1);
		$notification = new \Game\Notification($sampleNotifications[$notificationID]['title'],$sampleNotifications[$notificationID]['text'],$sampleNotifications[$notificationID]['moneyAdd'],$sampleNotifications[$notificationID]['moneySub']);
		
		\Core\i::Session()->getUserInstance()->addNotification($notification);
	}
	
	/**
	* Erstellt eine neue Test-Aufgabe (DEBUG-Funktion)
	**/
	private function newTasks() {
		$taskManager = \Game\Task\i::Manager();
	
		$sampleTasks = array();
		$sampleTasks[] = array('title'=>'RE6 von Düsseldorf nach Hamm','description'=>'Der RE6 muss von Düsseldorf nach Hamm gebracht werden. Die Strecke ist stark ausgelastet.','plops'=>125000, 'type'=>Task::WITH_APPLICATION,'stations'=>array(14,81,82,83,27,84),'neededCapacity'=>array(0=>0));
		$sampleTasks[] = array('title'=>'RE7 von Mannheim nach Saarbrücken','description'=>'Der RE7 fährt nach Saarbrücken und ist nicht besonders ausgelastet.','plops'=>100000, 'type'=>Task::WITH_APPLICATION,'stations'=>array(15,38,39,22),'neededCapacity'=>array(0=>0));
		$sampleTasks[] = array('title'=>'Güterzug von Saarbrücken nach Paderborn','description'=>'Die Autos müssen sicher nach Paderborn gebracht werden.','plops'=>200000, 'type'=>Task::NO_APPLICATION,'stations'=>array(22,29),'neededCapacity'=>array(4=>80));
		$sampleTasks[] = array('title'=>'Güterzug von Frankfurt nach Kassel','description'=>'Du musst eine Ladung Holz nach Kassel bringen.','plops'=>200000, 'type'=>Task::NO_APPLICATION,'stations'=>array(9,26),'neededCapacity'=>array(1=>2000));
		
		foreach($sampleTasks as $currentTask) {
			$task = new \Game\Task($currentTask['title'],$currentTask['description'],$currentTask['plops'],$currentTask['type']);
			$task->setStationIDs($currentTask['stations']);
			$task->setNeededCapacity($currentTask['neededCapacity']);
			
			$taskManager->addObject($task);
		}
	}
	
	/**
	* Entsperrt alle eigenen Zugeinheiten (DEBUG-Funktion)
	**/
	private function unlockAllTrainUnits() {
		$userInstance = \Core\i::Session()->getUserInstance();
		foreach($userInstance->listTrainUnits() as $currentTrainUnit)
			$currentTrainUnit->unlock();
	}
	
	/**
	* Zieht alle Bewerbungen des Spielers zurück (DEBUG-Funktion)
	**/
	private function revokeApplications() {
		$taskManager = \Game\Task\i::Manager();
		$taskManager->loadAll();
	
		$userInstance = \Core\i::Session()->getUserInstance();
		foreach($taskManager->listObjects() as $currentTask)
			$currentTask->revokeApplicationForUser($userInstance);
	}
	
	/**
	* Alle Ausschreibungen löschen
	**/
	private function removeAllTasks() {
		$taskManager = \Game\Task\i::Manager();
		$taskManager->loadAll();
		
		foreach($taskManager->listObjects() as $currentID => $null)
			$taskManager->removeObject($currentID);
	}

}