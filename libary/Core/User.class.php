<?php
/**
*
* Die Klasse verwaltet den Benutzer, lässt eine Registrierung und eine Löschung eines Users zu.
* Datum: 27. Juni 2012
*
**/
namespace Core;

class User extends Cache {
	use Cache\Vars;

	const PASS_MIN_LENGTH = 6;
	const MAIL_MATCH = '/^[a-zA-Z0-9-_.]+@[a-zA-Z0-9-_.]+\.[a-zA-Z]{2,4}$/';
	const NAME_MIN_LENGTH = 4;
	const NAME_MAX_LENGTH = 15;
	const NAME_MATCH = '/^[a-zA-Z0-9-_.]+$/';
		
	protected $dataArray;
	protected $saveInDB = array();
	
	protected $userID, $userName, $userPass, $userMail;
	protected $notifications = array();
	
	protected $tableActions;
	
	/**
	* Öffnet eine neue User-Klasse mithilfe der userID.
	*
	* @param int $userID - User-ID
	**/
	public function __construct($userID) {
		if (static::existInstanceFor($userID)) throw new \Exception('Es ist bereits eine Instanz für diesen User vorhanden.', 1030);
		
		$this->tableActions = i::MySQL()->tableActions('user');
		$mysqlObject = $this->tableActions->select(array('id'=>$userID));
		
		if($mysqlObject->numRows() != 1)
			throw new Exception('Ein User mit dieser ID existiert nicht.', 1031);			
		
		$this->dataArray = $mysqlObject->fetch();
		$this->userID = $this->dataArray['id'];
		$this->userName = $this->dataArray['name'];
		$this->userPass = $this->dataArray['pass'];
		$this->userMail = $this->dataArray['mail'];
		$this->notifications = unserialize($this->dataArray['notifications']);
		if(!is_array($this->notifications)) $this->notifications = array();
	}
	
	/**
	* Schließt die User-Klasse und speichert alle geänderte Werte in die Datenbank
	**/
	public function __destruct() {
		$this->saveInDB['name'] = $this->userName;
		$this->saveInDB['pass'] = $this->userPass;
		$this->saveInDB['mail'] = $this->userMail;
		$this->saveInDB['notifications'] = serialize($this->notifications);
		
		$this->tableActions->update($this->saveInDB,array('id'=>$this->userID));
		
		unset(static::$instances[$this->userID]);
	}
	
	/**
	* Gibt die UserID zurück.
	*
	* @return int - Die ID des Users
	**/
	public function getUserID() {
		return $this->userID;
	}
	
	/**
	* Gibt den User-Namen zurück.
	*
	* @return String - Der Name des Users
	**/
	public function getUserName() {
		return $this->userName;
	}
	
	/**
	* Gibt das Passwort als sha1-Hash zurück
	*
	* @return String - Passwort-Hash
	**/
	public function getUserPass() {
		return $this->userPass;	
	}
	
	/**
	* Überprüft neue Usernamen und gibt eventuelle Fehler zurück.
	* 
	* @param String $firstPass - Passwort
	**/
	private static function validateUserName($userName) {
		if (strlen($userName) < static::NAME_MIN_LENGTH)
			throw new \HumanException('Der ausgesuchte Benutzername ist zu kurz.', -1);
		if (strlen($userName) > static::NAME_MAX_LENGTH)
			throw new \HumanException('Der ausgesuchte Benutzername ist zu lang.', -2);
		if (!preg_match(static::NAME_MATCH, $userName))
			throw new \HumanException('Der ausgesuchte Benutzername enthält Leerzeichen oder andere Sonderzeichen.', -3);
		if (static::existUserName($userName))
			throw new \HumanException('Der ausgesuchte Benutzername wird bereits von einem anderen Benutzer genutzt.', -4);
	}
	
	/**
	* Überprüft neue Passwörter und gibt eventuelle Fehler zurück.
	* 
	* @param String $firstPass - Passwort
	* @param String $secondPass - Passwort-Wiederholung
	**/
	private static function validateUserPass($firstPass, $secondPass) {
		if (strlen($firstPass) < static::PASS_MIN_LENGTH)
			throw new \HumanException('Das eingegebene Passwort ist zu kurz.', -1);
		if ($firstPass != $secondPass)
			throw new \HumanException('Die zwei eingegebenen Passwörter stimmen nicht überein.', -2);
	}
	
	/**
	* Hast das Passwort für die User
	*
	* @param $pass - Das zu hashende Passwort
	* @return String - Das gehaste Passwort
	**/
	private static function hashUserPass($pass) {
		return sha1($pass);
	}
	
	/**
	* Hasht und setzt das User-Passwort
	*
	* @param String $firstPass - Passwort
	* @param String $secondPass - Passwort-Wiederholung
	**/
	public function setUserPass($firstPass, $secondPass) {
		static::validateUserPass($firstPass, $secondPass);
		
		$passHash = static::hashUserPass($firstPass);
		$this->userPass = $passHash;
	}
	
	/**
	* Gibt die E-Mail des Users zurück
	*
	* @return - E-Mail-Adresse
	**/
	public function getUserMail() {
		return $this->userMail;
	}
	
	/**
	* Überprüft die E-Mail und gibt eventuelle Fehler zurück.
	*
	* @param String $mail - Die E-Mail-Adresse
	**/
	private static function validateUserMail($mail) {
		if (!preg_match(static::MAIL_MATCH, $mail))
			throw new \HumanException('Die eingegebene E-Mail-Adresse ist keine gültige E-Mail-Adresse.', -1);
	}
	
	/**
	* Ändert die User-Mail
	*
	* @param String $mail - Die E-Mail-Adresse
	**/
	public function setUserMail($mail) {
		static::validateUserMail($mail);
	
		$this->userMail = $mail;
	}
	
	/**
	* Fügt eine neue Notification dem User hinzu
	*
	* @param Notification $notification - Eine neue Notification
	**/
	public function addNotification(Notification $notification) {
		$this->notifications[] = $notification;
	}
	
	/**
	* Löscht eine Notification.
	*
	* @param int $notificationID - Die ID
	**/
	public function removeNotification($notificationID) {
		unset($this->notifications[$notificationID]);
	}
	
	/**
	* Gibt die Benachrichtigungen des Users zurück
	*
	* @return array[Notification] - Array mit Benachrichitungen
	**/
	public function listNotifications() {
		return $this->notifications;
	}
	
	/**
	* Erstellt einen neuen Nutzer
	*
	* @param String $name - Der Nutzer-Name des Nutzers
	* @param String $firstPass - Passwort
	* @param String $secondPass - Passwort-Wiederholung
	* @param String $mail - Die Mail des Nutzers
	* @param array $moreInformations - Mehr Dinge, die geschrieben werden müssen.
	* @return User - Die User-Klasse des neuen Nutzers
	**/
	public static function createNewUser($name, $firstPass, $secondPass, $mail, array $moreInformations = array()) {
		static::validateUserName($name);
		static::validateUserPass($firstPass,$secondPass);
		static::validateUserMail($mail);
	
		$passHash = static::hashUserPass($firstPass);
		
		$contentArray = array('name'=>$name,'pass'=>$passHash,'mail'=>$mail) + $moreInformations;
		$queryObject = i::MySQL()->tableActions('user')->insert($contentArray);
		
		return static::instanceFor($queryObject->getLastID());
	}
	
	/**
	* Überprüft, ob ein Benutzername existiert
	*
	* @param String $userName - Der zu überprüfende Benutzername
	* @return bool - true = ja / false = nein
	**/
	public static function existUserName($userName) {
		$queryObject = i::MySQL()->tableActions('user')->select(array('name'=>$userName));
		if ($queryObject->numRows() > 0) return true;
		
		return false;
	}
	
	/**
	* Logt einen Benutzer ein, gibt entweder eine gültige User-Klassen-Instanz zurück oder ein false.
	*
	* @param String $userName - Name des Nutzers
	* @param String $userPass - Passwort des Nutzers
	* @param bool $noHash - Nicht hashen, da bereit gehasht. [optional]
	* @return User - Entweder eine gültige User-Instanz
	**/
	public static function loginUser($userName, $userPass, $noHash = false) {
		if (!$noHash) $passHash = static::hashUserPass($userPass);
		else $passHash = $userPass;
		$queryObject = i::MySQL()->tableActions('user')->select(array(array('name'=>$userName,'mail'=>$userName),'pass'=>$passHash));
		if ($queryObject->numRows() == 0)
			throw new \HumanException('Der Login ist fehlgeschlagen. Überprüfe auch Groß- und Kleinschreibung des Passworts.', -1);		
		
		$content = $queryObject->fetch();
		return static::instanceFor($content['id']);
	}
	
	/**
	* Diese Methode gibt zurück, wie viele Spieler derzeit registriert sind.
	*
	* @return Int - Die Anzahl der Spieler
	**/
	public static function countUser() {
		$count = i::MySQL()->tableActions('user')->count();
		return $count;
	}
}
?>