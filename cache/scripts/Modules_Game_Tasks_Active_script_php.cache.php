<?php
/**
*
* Einer Übersicht über alle aktiven Ausschreibungen.
* Datum: 12. Dezember 2012
*
**/
namespace Script; class Modules_Game_Tasks_Active_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Aktive Ausschreibungen');
		
		if(isset($options['application']) && $options['application'] == 'success') {
			$this->mi()->addVarCache('showSuccess', true);
			$this->mi()->addVarCache('successString', 'Die Zugeinheit wurde erfolgreich losgeschickt. Den aktuelle Status findest du auf dieser Seite.');
		}
		
		$userTaskJourneyManager = \Game\Task\Journey\i::Manager($this->ui()->getUserid());
		$userTaskJourneyManager->loadAll();
		$this->mi()->addVarCache('taskJourneyList', $userTaskJourneyManager->listObjects());
	}
}
?>