<?php
/**
*
* Eine Benachrichtigung für den User mit Game-Erweiterungen
* Datum: 14. November 2012
*
**/
namespace Game;

class Notification extends \Core\Notification {
	protected $plopsAdd, $plopsSub, $delay;

	/**
	* Erstellt eine neue Notification.
	*
	* @param String $title - Betreff der Benachrichtigung
	* @param String $text - Text der Benachrichtigung
	* @param int $plopsAdd - Geld, dass dadurch hinzugekommen ist. [optional]
	* @param int $plopSub - Geld, dass dadurch verloren gegangen ist. [optional]
	* @param \Game\Task\Journey\Delay $delay - Eine Verspätung ist aufgetreten? [optional]
	**/
	public function __construct($title, $text, $plopsAdd=0, $plopsSub=0, \Game\Task\Journey\Delay $delay = NULL) {
		parent::__construct($title, $text);
		
		$this->plopsAdd = $plopsAdd;
		$this->plopsSub = $plopsSub;
		$this->delay = $delay;
	}
	
	/**
	* Gibt zurück, wie viel Geld hinzugekommen ist.
	*
	* @return int - Neues Geld
	**/
	public function getPlopsAdd() {
		return $this->plopsAdd;
	}
	
	/**
	* Gibt zurück, wie viel Geld verloren gegangen ist.
	*
	* @return int - Verlorenes Geld
	**/
	public function getPlopsSub() {
		return $this->plopsSub;
	}
	
	/**
	* Gibt die Verspätung zurück
	*
	* @return \Game\Task\Journey\Delay - Verspätungs-Objekt
	**/
	public function getDelay() {
		return $this->delay;
	}
}
?>