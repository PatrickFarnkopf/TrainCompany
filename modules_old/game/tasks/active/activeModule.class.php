<?php
if(!defined('INC')) exit;
/**
*
* Einer Übersicht über alle aktiven Ausschreibungen.
* Datum: 12. Dezember 2012
*
**/
class activeModule {
	public function __construct() {
		$options = cmi()->getVarCache('options');
		cmi()->addVarCache('siteTitle', 'Aktive Ausschreibungen');
		
		if(isset($options['application']) && $options['application'] == 'success') {
			cmi()->addVarCache('showSuccess', true);
			cmi()->addVarCache('successString', 'Die Zugeinheit wurde erfolgreich losgeschickt. Den aktuelle Status findest du auf dieser Seite.');
		}
		
		$userInstance = i::Session()->getUserInstance();
		$userTaskJourneyManager = i::TaskJourneyManager($userInstance->getUserID());
		$userTaskJourneyManager->loadAll();
		cmi()->addVarCache('taskJourneyList', $userTaskJourneyManager->listObjects());
	}
}
?>