<?php
/**
*
* Liste mit neuen Notifications. (Auschließlich)
* Datum: 16. November 2012
*
**/
script {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		
		$newNotifications = [];
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