<?php
/**
*
* Liste mit neuen Notifications. (Auschließlich)
* Datum: 16. November 2012
*
**/
namespace Script; class Modules_Game_XML_Notifications_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		
		$newNotifications = array();
		foreach($this->mi()->getVarCache('currentUserNotifications') as $notificationID => $currentNotification) {
			if($currentNotification->isSended()) continue;
			
			$newNotifications[$notificationID] = $currentNotification;
			
			$currentNotification->setSended();
			// Bitte nur eine Benachrichtigung auf einmal.
			break;
		}
		$this->mi()->addVarCache('newNotifications', $newNotifications);
	}
}
?>