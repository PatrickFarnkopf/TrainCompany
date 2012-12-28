<?php
/**
*
* Einer Übersicht über alle Daten für den Spieler.
* Datum: 17. Oktober 2012
*
**/

namespace Script; class Modules_Game_Overview_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		
		$this->mi()->addVarCache('siteTitle', 'Übersicht');
		
		$userInstance = \Core\i::Session()->getUserInstance();
		$this->mi()->addVarCache('countTrainUnits', $userInstance->countTrainUnits());
		$this->mi()->addVarCache('averageAgeOfTrainUnits', $userInstance->getAverageAgeOfTrainsUnits());
		$this->mi()->addVarCache('sellPriceOfTrainsUnits', $userInstance->getSellPriceOfTrainsUnits());
	
		$taskManager = \Game\Task\i::Manager();
		$userTaskJourneyManager = \Game\Task\Journey\i::Manager($userInstance->getUserID());
		$this->mi()->addVarCache('countTasks', $taskManager->countAllObjects());
		$this->mi()->addVarCache('countTaskJourneys', $userTaskJourneyManager->countAllObjects()); 
	}
	
}