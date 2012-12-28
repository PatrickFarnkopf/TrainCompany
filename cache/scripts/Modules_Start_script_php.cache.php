<?php
/**
*
* Die Klasse des Startseiten-Modules
* Datum: 27. Juni 2012
*
**/
namespace Script; class Modules_Start_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		
		$this->mi()->addVarCache('siteTitle', 'Startseite');
		$this->mi()->addVarCache('showError', false);
		$this->mi()->addVarCache('showSuccess',false);
		
		$this->mi()->addVarCache('userCount', \Game\User::countUser());
		
		if(isset($options['regSuccessfull']) && $options['regSuccessfull']) {
			$this->mi()->addVarCache('showSuccess',true);
			$this->mi()->addVarCache('successString', 'Die Registrierung war erfolgreich. Du kannst dich jetzt mit deinen Login-Daten einloggen.');
		} else if (isset($options['installationSuccessfull']) && $options['installationSuccessfull']) {
			$this->mi()->addVarCache('showSuccess',true);
			$this->mi()->addVarCache('successString', 'Die Installation von „TrainCompany“ war erfolgreich. Los geht’s!');
		}
	
		try {
			if(isset($options['currentSession']) && $options['currentSession'] == 'invalid')
				throw new \HumanException('Deine Sitzung ist nicht mehr valid. Bitte logge dich erneut ein.', -1);
			
			if (isset($options['login']) && $options['login'] == true) $this->login();
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
		
	}
	
	/**
	* Führt einen Login aus, lädt die dazu benötitgten Daten aus dem $_POST-Array.
	**/
	private function login() {
		$userName = isset($_POST['userName']) ? $_POST['userName'] : '';
		$userPassword = isset($_POST['userPassword']) ? $_POST['userPassword'] : '';
		
		$loginResult = \Game\User::loginUser($userName, $userPassword);

		// Session erstellen uns speichern
		$sessionInstace = new \Core\Session($loginResult);
		$sessionInstace->saveInstance();
		
		\Core\Module::goToModule('Game');
	}
}
?>