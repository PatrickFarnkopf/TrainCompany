<?php
/**
*
* Überprüft eventuell vorhandene Sitzungen.
* Datum: 3. Juli 2012
*
**/
namespace Core;

class Session extends Singleton {
	use VarCache, Singleton\Vars;

	const SESSION_NAME = 'CORE_SESSION';
	const SESSION_INSTANCE = 'SESSION_INSTANCE';
	const INACTIVE_TIME = 1800;
	
	private $userInstance;
	private $userClassname;
	
	private $userName;
	private $userPass;
	private $lastActivity;
	
	/**
	* Initialisiert die Session-Umgebung
	**/
	public static function init() {
		static $init = false;
		
		// Überpürfen, ob wir bereits initialisiert haben.
		if($init)
			throw new \Exception('Die Session-Klasse wurde bereits initialisiert.', 1071);
		
		// Den Namen des Cookies setzen
		session_name(self::SESSION_NAME);
		// Session starten
		session_start();
		
		// Die Klasse wurde initialisiert.
		$init = true;
	}
	
	/**
	* Öffnet eine neue User-Session-Instance
	*
	* @param User $userInstance - Die Instance des Users
	**/
	public function __construct(User $userInstance) {
		$this->userInstance = $userInstance;
		$this->userClassname = new Classname(get_class($userInstance));
		
		$this->userName = $this->userInstance->getUserName();
		$this->userPass = $this->userInstance->getUserPass();
		$this->lastActivity = time();
	}
	
	/**
	* Bitte keine User-Instanz mit speichern, sonst werden Änderungen einfach nicht übernommen. :(
	*
	* @return array
	**/
	public function __sleep() {
		return ['userName','userPass','lastActivity','userClassname','varCache','isFunction'];
	}
	
	/**
	* Überprüft die Login-Daten auf Korrektheit
	*
	* @return bool - Sind die Daten nur valid? (ja=true/nein=false)
	**/
	public function recheckLoginData() {
		if($this->lastActivity + self::INACTIVE_TIME < time()) return false;
		$this->lastActivity = time();
		
		$className = $this->userClassname->getFullClassname();
		$this->userInstance = $className::loginUser($this->userName, $this->userPass, true);
		if(!$this->userInstance) return false;
		
		return true;
	}
	
	/**
	* Ändert das Passwort des in der Session gespeicherten User OHNE in danach rauszuwerfen.
	*
	* @param String $firstPass - Passwort
	* @param String $secondPass - Passwort-Wiederholung
	**/
	public function changeUserPass($firstPass,$secondPass) {
		$this->userInstance->setUserPass($firstPass,$secondPass);
		$this->userPass = $this->userInstance->getUserPass();
	}
	
	/**
	* Gibt die aktuelle User-Instanz zurück
	*
	* @return User - Aktuelle User-Instanz
	**/
	public function getUserInstance() {
		return $this->userInstance;
	}
	
	/**
	* Lädt diese Session-Instance in den Session-Speicher
	**/
	public function saveInstance() {
		static::setMainInstance($this);
	}
	
	/**
	* Setzt eine Hauptinstanz
	*
	* @param Cache $mainInstance - Hauptinstanz
	**/
	public static function setMainInstance(Singleton $mainInstance) {
		$_SESSION[self::SESSION_INSTANCE] = $mainInstance;
	}
	
	/**
	* Gibt zurück, ob eine Instanz als Hauptinstanz gesetzt ist.
	*
	* @return bool - Hauptinstanz vorhanden?
	**/
	public static function existMainInstance() {
		return isset($_SESSION[self::SESSION_INSTANCE]);
	}
	
	/**
	* Gibt die Hauptinstanz zurück, falls vorhanden. Wenn nicht wird eine Exception geworfen
	*
	* @return static - Die Haupinstanz dieser Klasse
	**/
	public static function mainInstance() {
		if(!static::existMainInstance()) throw new \Exception('Es ist keine Session-Instance im Speicher vorhanden.', 1070);
		
		return $_SESSION[self::SESSION_INSTANCE];
	}
	
	/**
	* Löscht die Hauptinstanz aus dem Speicher.
	**/
	public static function unsetMainInstance() {
		unset($_SESSION[self::SESSION_INSTANCE]);
	}
}
?>