<?php
/**
*
* Baut eine Verbindung mit der MySQL-Datenbank auf und verwaltet Anfragen
* Datum: 28. Juni 2012
*
**/
namespace Core;

class MySQL extends Cache {
	use Cache\Vars;
	
    private $resource;

    /**
    * Öffnet eine MySQL-Verbindung.
    * 
    * @param string $serverName - Der MySQL-Servername
    * @param string $userName - Der MySQL-Username
    * @param string $userPassword - Das MySQL-Passwort
    * @param string $database - Der Name der Datenbank [optional]
    * @param bool $mainInstance - Als Hauptinstanz öffnen [optional]
    **/
    public function __construct($serverName, $userName, $userPassword, $database = false, $mainInstance = true) {
	    if($mainInstance) {
    		if (static::existMainInstance()) throw new \Exception('Es gibt bereits eine MySQL-Hauptinstanz.', 1062);
    		static::setMainInstance($this);
    	}
    
        $this->resource = mysql_connect($serverName, $userName, $userPassword);
        if($database) $this->connectDatabase($database);
    }
    
    /**
    * Gibt die MySQL-Resource zurück.
    *
    * @return resource
    **/
    public function getResource() {
	    return $this->resource;
    }
    
    /**
    * Verbindet sich mit einer Datenbank.
    *
    * @param string $database - Der Name der Datenbank
    **/
    public function connectDatabase($database) {
	   	if(!mysql_select_db($database, $this->resource))
	   		throw new \Exception('Die ausgewählte Datenbank "'.$database.'" existiert nicht.', 1060);
    }
    
    /**
    * Erstellt eine Datenbank, falls sie nicht existiert.
    *
    * @param String $name - Name der Datenbank
    **/
    public function createDatabase($name) {
		if(!$this->queryObject("CREATE DATABASE IF NOT EXISTS ".$this->escapeString($name)))
			throw new \Exception('Die Datenbank "'.$name.'" konnte nicht erstellt werden.', 1061);
    }

    /**
    * Maskiert alle Sonderzeichen, so dass der String sicher ist.
    *
    * @param String $string - Der zu maskierende String
    * @return String - Der maskierte String
    **/
    public function escapeString($string) {
	    return mysql_real_escape_string($string, $this->resource);
    }
    
    /**
    * Gibt eine MySQLTable-Instanz zurück.
    *
    * @param string $table - Die Tabelle
    * @return MySQLTable - Die Tabelle
    **/
    public function tableActions($table) {
	    return new MySQL\Table($this, $table);
    }
    
    /**
    * Fürt mehrere MySQL-Anfragen auf einmal aus.
    *
    * @param string $sql - Abfragen
    **/
    public function queries($sql) {
	    $queries = preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/", $sql); 
		foreach ($queries as $query){ 
			if (strlen(trim($query)) > 0) $this->queryObject($query); 
		} 
    }
    
    /**
    * Führt eine SQL-Abfrage durch und gibt ein Query-Objekt zurück.
    * Sollte die SQL-Abfrage schiefgehen, wird das Programm abgebrochen und eine Fehlermeldung wird angezeigt.
    * 
    * @param string $sql - Die MySQL-Anfrage
    * @return MySQLQuery - Gibt ein Query-Objekt zurück
    **/
    public function queryObject($sql) {
        $queryResource = mysql_query($sql, $this->resource);
        if($queryResource === false) throw new MySQL\Exception($this->errorString(),$this->errorNumber());
        
        return new MySQL\Query($this, $queryResource);
    }
    
    /**
    * Gibt die letzte MySQL-Fehlernummer zurück.
    *
    * return int - Die Fehlernummer
    **/
    public function errorNumber() {
	    return mysql_errno($this->resource);
    }
    
    /**
    * Gibt die letzte MySQL-Fehlermeldung zurück.
    *
    * return String - Die Fehlermeldung
    **/
    public function errorString() {
	    return mysql_error($this->resource);
    }
    
    /**
    * Öffnet eine MySQL-Klassen-Instanz mit den in der Config eingetragenen werten.
    *
    * @param $mainInstance - Als Hauptinstanz öffnen [optional]
    * @return \Core\MySQL
    **/
    public static function connectWithConfigData($mainInstance = true) {
	    $server = \Config\MySQL\SERVER;
	    $user = \Config\MySQL\USER;
	    $password = \Config\MySQL\PASS;
	    $database = \Config\MySQL\DATABASE;
	    
	    return new static($server, $user, $password, $database, $mainInstance);
    }
}
?>