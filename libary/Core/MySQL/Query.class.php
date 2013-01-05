<?php
/**
*
* Eine Instanz dieser Klasse wird als Resourcen-Ersatz bei jeder Query zurückgegeben.
* Datum: 30. November 2012
*
**/
namespace Core\MySQL;

class Query {
	private $mysqlInstance, $resource;
	private $lastID = false, $affectedRows = false;
	
	/**
	* Öffnet eine neue Instanz von MySQLQuery
	*
	* @param MySQL $mysqlInstance - Die MySQL-Instanz
	* @param resource $resource - Die Query-Resource
	**/
	public function __construct(\Core\MySQL $mysqlInstance, $resource) {
		$this->mysqlInstance = $mysqlInstance;
		$this->resource = $resource;
		
		if(is_bool($resource)) {
			$this->affectedRows = mysql_affected_rows($this->mysqlInstance->getResource());
			$this->lastID = mysql_insert_id($this->mysqlInstance->getResource());
		}
	}
	
	/**
    * Gibt das mysql_fetch_array()-Array zurück.
    * Kann nur aus dem queryMode aufgerufen werden.
    * 
    * @return array - Array mit Inhalt
    **/
    public function fetch() {
        return mysql_fetch_array($this->resource);
    }
	
	/**
    * Zählt die Zeilen der aktuellen SQL-Abfrage.
    * 
    * @return int - Anzahl der Zahlen
    **/
    public function numRows() {
    	if($this->affectedRows !== false) return $this->affectedRows;
        return mysql_num_rows($this->resource);
    }
    
    /**
    * Gibt die zuletz eingefügte ID zurück
    *
    * return int - Die letzte ID
    **/
    public function getLastID() {	    
	    return $this->lastID;
    }

}