<?php
/**
*
* Verwaltet die System-Ausschreibungen
* Datum: 28. November 2012
*
**/
namespace Game\Task;

class Manager extends \Core\Manager {
	use \Core\Cache\Vars;

	/**
	* Lädt alle „abgelaufenen“ Auschreibungen aus der Datenbank
	**/
	public function loadExpired() {
		$queryObject = $this->tableActions->select('endTime != 0 AND endTime <= '.time());
		
		$this->saveInInstance($queryObject);
	}
	
	/**
	* Setzt die Table-Actions-Instanz
	**/
	protected function setTableActions() {
		$this->tableActions = \Core\i::MySQL()->tableActions('tasks');
	}
	
	/**
	* Gibt das Content-Array für ein Objekt zurück
	*
	* @param object $object - Das Objekt
	* @return array - Content-Array
	**/
    protected function getContentArrayForObject($object) {
	    $contentArray = [];
		$contentArray['object'] = serialize($object);
		$contentArray['endTime'] = $object->getEndTime();
		
		return $contentArray;
    }
}
?>