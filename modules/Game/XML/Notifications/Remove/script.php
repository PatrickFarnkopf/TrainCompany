<?php
/**
*
* Löscht eine Notification
* Datum: 16. November 2012
*
**/
script {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		
		if(isset($options['deleteID'])) $this->deleteNotification($options['deleteID']);
	}
	
	/**
	* Löscht eine Benachrichtigung.
	*
	* @param int $notificationID - Benachrichtigungs-ID
	**/
	private function deleteNotification($notificationID) {
		$this->ui()->removeNotification($notificationID);
	} 
}
?>