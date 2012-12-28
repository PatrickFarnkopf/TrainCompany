<?php
/**
*
* Verwaltet die laufenden Ausschreibungen aus der Datenbanke
* Datum: 11. Dezember 2012
*
**/
namespace Game\Task\Journey;

class Manager extends \Core\Manager {
	use \Core\Cache\Vars;
	
	const GROUPID_FIELDNAME = 'userID';
	
	/**
	* Lädt alle Zugfahrten, bei denen eine Aktion benötigt wird.
	**/
	public function loadActionNeeded() {
		$queryObject = $this->tableActions->select('nextStepTime != 0 AND nextStepTime <= '.time());
		
		$this->saveInInstance($queryObject);
	}
	
	/**
	* Setzt die Table-Actions-Instanz
	**/
	protected function setTableActions() {
		$this->tableActions = \Core\i::MySQL()->tableActions('taskJourneys');
	}
	
	/**
	* Gibt das Content-Array für ein Objekt zurück
	*
	* @param object $object - Das Objekt
	* @return array - Content-Array
	**/
    protected function getContentArrayForObject($object) {
	    $contentArray = array();
		$contentArray['object'] = serialize($object);
		$contentArray['nextStepTime'] = $object->getNextStepTime();
		
		return $contentArray;
    }
}
?>