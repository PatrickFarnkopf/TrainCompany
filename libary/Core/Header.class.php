<?php
/**
*
* Unterstütung beim Senden eines Headers.
* Datum: 27.12.2012
*
**/
namespace Core;

class Header extends Cache {
	use Cache\Vars;

    private $status = array(	100	=> 'Continue',
	    						101 => 'Switching Protocols',
	    						200 => 'OK',
	    						201 => 'Created',
	    						202 => 'Accepted',
	    						203 => 'Non-Authoritative Information',
	    						204 => 'No Content',
	    						205 => 'Reset Content',
	    						206 => 'Partial Content',
	    						300 => 'Multiple Choices',
	    						301 => 'Moved Permanently',
	    						302 => 'Found',
	    						303 => 'See Other',
	    						304 => 'Not Modified',
	    						305 => 'Use Proxy',
	    						307 => 'Temporary Redirect',
	    						400 => 'Bad Request',
	    						401 => 'Unauthorized',
	    						402 => 'Payment Required',
	    						403 => 'Forbidden',
	    						404 => 'Not Found',
	    						405 => 'Method Not Allowed',
	    						406 => 'Not Acceptable',
	    						407 => 'Proxy Authentication Required',
	    						408 => 'Request Time-out',
	    						409 => 'Conflict',
	    						410 => 'Gone',
	    						411 => 'Length Required',
	    						412 => 'Precondition Failed',
	    						413 => 'Request Entity Too Large',
	    						414 => 'Request-URI Too Large',
	    						415 => 'Unsupported Media Type',
	    						416 => 'Requested range not satisfiable',
	    						417 => 'Expectation Failed',
	    						500 => 'Internal Server Error',
	    						501 => 'Not Implemented',
	    						502 => 'Bad Gateway',
	    						503 => 'Service Unavailable',
	    						504 => 'Gateway Time-out',
	    						505 => 'HTTP Version not supported');
	    							
	private $contentType = 'text/html';
	
	/**
	* Setzt den Standard-Content-Type und macht einen OB-Cache auf
	**/
	public function __construct() {
		// Existiert bereits eine Modul-Hauptinstanz?
		if(self::existMainInstance()) throw new \Exception('Es existiert bereits eine Header-Hauptinstanz.', 1132);
			
		// Die Hauptinstanz setzen
		self::setMainInstance($this);
		
		// Den Standard-Content-Type setzen
		if(!$this->isSent()) $this->setContentType($this->contentType);
		
		// OB-Cache starten, wenn nicht im DEBUG-Modus
		if(!\Config\DEBUG) ob_start();
	}
	
	/**
	* Gespeicherten Inhalt ausgeben.
	**/
	public function __destruct() {
		if(!\Config\DEBUG && ob_get_level()) ob_end_flush();
	}
	
	/**
    * Fügt eine Zeiel dem Header hinzu. Paramter siehe php.net
    *
    * @param string $string
    * @param bool $replace [optional]
    * @param int $httpResponseCode [optional]
    **/
    private function add($string, $replace=true, $httpResponseCode=null) {
		header($string, $replace, $httpResponseCode);
    }    							
	
    /**
	* Fügt ein neues Cookie hinzu. Parameter siehe php.net
    *
    * @param string $name
    * @param string $value [optional]
    * @param int $expire [optional]
    * @param string $path [optional]
    * @param string $domain [optional]
    * @param bool $secure [optional]
    * @param bool $httpOnly [optional]
    * @return bool
    **/
    private function addCookie($name, $value=null, $expire=0, $path=null, $domain=null, $secure=false, $httpOnly=false) {
		return setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

    /**
    * Schickt einen Status. Alle bekannten Status-Codes stehen in $status
    *
    * @param int $code - Der Status-Code
    * @param int $replace - Ersetzen? [optional]
    **/
    private function addStatus($code, $replace=true) {
    	// Existiert der angeforderte Status-Code?
		if(!isset($this->status[$code]))
	    	throw new \Exception('Unbekannter Status-Code „'.$code.'“ wurde versucht zu senden.', 1130);
	    
	    // Fügt den Code hinzu.
	    $this->add('HTTP/1.0 '.$code.' '.$this->status[$code],$replace);
    }

    /**
    * Fügt eine Weiterleitung dem Skript hinzu und beendet es dann.
    *
   	* @param string $url
    **/
    private function addLocation($url) {
		$this->add('Location: '.$url);
		exit;
    }
    
    /**
    * Setzt einen Content-Type
    *
    * @param string $contentType - Der Content-Type
    * @param string $charset - Charset [optional]
    **/
    private function setContentType($contentType, $charset='utf-8') {
	    $this->add('Content-Type: '.$contentType.'; charset='.$charset);
	    
	    $this->contentType = $contentType;
    }
    
    /**
	* Löscht alle Header oder spezifische
    *
    * @param string $name [optional]
    **/
    private function remove($name=false) {
		if($name===false) header_remove();
		else header_remove($name);
    }

    /**
    * Wurde der Header bereits gesendet?
    *
    * @return bool
    **/
    public function isSent() {
		return headers_sent();
    }

    /**
    * Gibt ein Array mit allen Header-Informationen
    *
    * return array
    **/
    public function getList() {
		return headers_list();
    }
    
    /**
    * Gibt den aktuellen Content-Type zurück
    *
    * @return string
    **/
    public function getContentType() {
	    return $this->contentType;
    }
    
    /**
    * Alle Privaten-Methoden werden mittels Überladung zur Verfügung gestellt.
    *	Vorher wird Überprüft, ob der Header bereits gesendet wurde
    *
    * @param string $name - Name der angeforderten Methode
    * @param  array $arguments - Argumente
    * @return mixed
    **/
    public function __call($name, array $arguments) {
    	// Exception werfen, wenn der Header bereits gesendet wurde.
    	if($this->isSent())
    		throw new \Exception('Der Header wurde bereits gesendet.', 1131);
	    
	    // Methode aufrufen
	    return call_user_func_array(array($this, $name), $arguments);
    }
}
?>