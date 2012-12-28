<?php
/**
*
* Eine Benachrichtigung für den User
* Datum: 14. November 2012
*
**/
namespace Core;

class Notification {
	protected $title, $text, $time;
	protected $sended = false;

	/**
	* Erstellt eine neue Notification.
	*
	* @param String $title - Betreff der Benachrichtigung
	* @param String $text - Text der Benachrichtigung
	* @param int $moneyAdd - Geld, dass dadurch hinzugekommen ist. [optional]
	* @param int $moneySub - Geld, dass dadurch verloren gegangen ist. [optional]
	**/
	public function __construct($title, $text) {
		$this->title = $title;
		$this->text = $text;
		$this->time = time();
	}
	
	/**
	* Gibt den Titel der Benachrichtigung zurück
	*
	* @return String - Titel
	**/
	public function getTitle() {
		return $this->title;
	}
	
	/**
	* Gibt den Inhalt der Benachrichtigung aus.
	*
	* @return String - Text
	**/
	public function getText() {
		return $this->text;
	}
	
	/**
	* Gibt die Zeit, an der die Benachrichtigung gesendet wurde, aus.
	*
	* @return int - Zeitstempel
	**/
	public function getTime() {
		return $this->time;
	}
	
	/**
	* Setzt die Benachrichtigung als gesendet.
	**/
	public function setSended() {
		$this->sended = true;
	}
	
	/**
	* Ist die Benachrichtigung an den User gesendet?
	*
	* @return bool - Ja/Nein
	**/
	public function isSended() {
		return $this->sended;
	}
}
?>