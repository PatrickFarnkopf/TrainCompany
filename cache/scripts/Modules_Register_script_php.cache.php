<?php
/**
*
* Die Klasse des Registrierungs-Modules
* Datum: 12. Oktober 2012
*
**/
namespace Script; class Modules_Register_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		
		$this->mi()->addVarCache('siteTitle', 'Registrierung');
		$this->mi()->addVarCache('showRegisterError', false);
		
		$this->mi()->addVarCache('userName', isset($_POST['userName']) ? $_POST['userName'] : '');
		$this->mi()->addVarCache('userMail', isset($_POST['userMail']) ? $_POST['userMail'] : '');
		$this->mi()->addVarCache('userPassword', isset($_POST['userPassword']) ? $_POST['userPassword'] : '');
		$this->mi()->addVarCache('userPasswordAgain', isset($_POST['userPasswordAgain']) ? $_POST['userPasswordAgain'] : '');
	
		try {
			if (isset($options['register']) && $options['register'] == true)
				$this->register();
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
	}
	
	/**
	 * Führt eine Registrierung durch und lädt die dafür benötigten Ressurcen
	 **/
	private function register() {
		// Neuen Nutzer in die Datenbank schreiben
		\Game\User::createNewUser($this->mi()->getVarCache('userName'),$this->mi()->getVarCache('userPassword'),$this->mi()->getVarCache('userPasswordAgain'),$this->mi()->getVarCache('userMail'));
		
		// Weiterleitung auf Startseite
		\Core\Module::goToModule('Start',array('regSuccessfull'=>true));
	}
}

?>