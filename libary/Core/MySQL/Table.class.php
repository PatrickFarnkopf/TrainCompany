<?php
/**
*
* Aufgaben, die mit einer Tabelle gemacht werden können.
* Datum: 30. November 2012
*
**/
namespace Core\MySQL;

class Table {
	private $table,$mysqlInstance;
	
	/**
	* Nimmt die Tabelle und die MySQL-Instanz zurück.
	*
	* @param MySQL $mysqlInstance - Die MySQL-Instanz
	* @param string $table - Die Tabelle
	**/
	public function __construct(\Core\MySQL $mysqlInstance, $table) {
		$this->mysqlInstance = $mysqlInstance;
		$this->table = $table;
	}
	
	/**
	* Gibt die Anzahl der Elemente in dieser Tabelle zurück.
	*
	* @param string/array $where - Welche? [oprional]
	* @return int - Anzahl
	**/
	public function count($where = '') {
		$sql = 'SELECT count(*) FROM '.$this->table;
		$sql .= self::makeWhereString($where);
		
		return $this->mysqlInstance->queryObject($sql)->fetch()['count(*)'];
	}
	
	/**
	* Gibt den Inhalt einer Tabelle mit den Konditionen zurück
	*
	* @param string/array $where - Welche? [optional]
	* @return MySQLQuery - MySQL-Instanz
	**/
	public function select($where = '') {
		$sql = 'SELECT * FROM '.$this->table;
		$sql .= self::makeWhereString($where);
		
		return $this->mysqlInstance->queryObject($sql);
	}
    
    /**
    * Fügt einen neuen Eintrag in die Tabelle.
    *
    * @param array $content - Inhalt
    * @return MySQLQuery - Query-Objekt
    **/
    public function insert(array $content) {
	    $sql = 'INSERT INTO '.$this->table;
	    $sql .= self::makeSetString($content);
	    
	    return $this->mysqlInstance->queryObject($sql);
    }
    
    /**
    * Updatet einen Eintrag in der Tabelle
    *
    * @param array $content - Inhalt
    * @param string/array $where - Welches?
    * @return MySQLQuery - Query-Object
    **/
    public function update(array $content, $where) {
	    $sql = 'UPDATE '.$this->table;
	    $sql .= self::makeSetString($content);
	    $sql .= self::makeWhereString($where);
	    
	    return $this->mysqlInstance->queryObject($sql);
    }
    
    /**
    * Löscht einen Eintrag in der Tabelle
    *
    * @param string/array $where - Welches?
    * @return MySQLQuery - Query-Object
    **/
    public function delete($where) {
	    $sql = 'DELETE FROM '.$this->table;
	    $sql .= self::makeWhereString($where);
	    
	    return $this->mysqlInstance->queryObject($sql);
    }
    
    
    /**
    * Macht einen SQL-Set-String aus einem Array
    *
    * @param array $content - Inhalt
    * @return string - Der SQL-String
    **/
    private static function makeSetString(array $content) {
	    $setString = '';
		foreach($content as $colName => $value) {
			if (!empty($setString)) $setString .= ', ';
			$setString .= $colName."='".escapeMySQL($value)."'";
		}
		
		return ' SET '.$setString.' ';
    }
    
    /**
    * Macht einen SQL-Set-String aus einem Array
    *
    * @param string/array $content - Inhalt
    * @return string - Der SQL-String
    **/
    private static function makeWhereString($content) {
    	if(is_array($content)) {
	    	$setString = '';
	    	foreach($content as $colName => $value) {
				if (!empty($setString)) $setString .= ' AND ';
				
				// Ein Array? Dann Oder-Verknüpfung
				if(is_array($value)) {
					$setString .= '( ';
					$start = true;
					foreach($value as $colName => $value) {
						if (!$start) $setString .= ' OR ';
						
						$setString .= $colName."='".escapeMySQL($value)."'";
						
						$start = false;
					}
					$setString .= ') ';
				} else
					$setString .= $colName."='".escapeMySQL($value)."'";
			}
		
			return ' WHERE '.$setString.' ';
		} else if(!empty($content))
	    	return ' WHERE '.$content.' ';
	   
    }
}
?>