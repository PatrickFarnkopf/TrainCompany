<?php
/**
*
* Oberfläche zur Änderung des Passwords und der E-Mail-Adresse
* Datum: 5. November 2012
*
**/
script {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');

		$this->mi()->addVarCache('userPass', isset($_POST['userPass']) ? $_POST['userPass'] : '');
		$this->mi()->addVarCache('userPassAgain', isset($_POST['userPassAgain']) ? $_POST['userPassAgain'] : '');
		$this->mi()->addVarCache('currentUserMail', \Core\i::Session()->getUserInstance()->getUserMail());
		$this->mi()->addVarCache('userMail', isset($_POST['userMail']) ? $_POST['userMail'] : '');
		
		try {
			if (isset($options['changeMail']) && $options['changeMail'] == true)
				$this->mailChange();
		
			if (isset($options['changePass']) && $options['changePass'] == true)
				$this->passChange();
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
	}
	
	/**
	* Ändert das Passwort
	**/
	private function passChange() {
		\Core\i::Session()->changeUserPass($this->mi()->getVarCache('userPass'), $this->mi()->getVarCache('userPassAgain'));
		
		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', "Das Passwort wurde erfolgreich geändert. :)");
		
		$this->mi()->addVarCache('userPass', '');
		$this->mi()->addVarCache('userPassAgain', '');
	}
	
	/**
	* Ändert die E-Mail-Adresse
	**/
	private function mailChange() {
		$this->ui()->setUserMail($this->mi()->getVarCache('userMail'));
	
		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', "Die E-Mail-Adresse wurde erfolgreich geändert. :)");
		
		$this->mi()->addVarCache('userMail', '');
	}
}
?>