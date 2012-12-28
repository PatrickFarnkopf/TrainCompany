<?php
/**
*
* Führt eine Installation durch, sammelt dazu benötigte Daten und schreibt sie in die Konfigurations-Datei.
* Datum: 19. Oktober 2012
*
**/
namespace Core;

class Install {
	const FILE = 'config.inc.php';
	const SQL_FILE = '/docs/tables.sql';
	
	const REQUIERED_MEMORY_SIZE = '32M';
	const REQUIERED_PHP_VERSION = '5.4';
	
	private $knowConfigurations = 	array(
										'INSTALLED' => NULL,
										'INSTALL_TIME' => NULL,
										'DEBUG' => \Config\DEBUG,
										'TIME_ZONE' => \Config\TIME_ZONE,
										'Version' => 	array(
															'STRING' => \Config\Version\STRING,
															'LICENSE_FILE' => \Config\Version\LICENSE_FILE
														),
										'MySQL' =>		array(
															'SERVER' => NULL,
															'USER' => NULL,
															'PASS' => NULL,
															'DATABASE' => \Config\MySQL\DATABASE
														)
									);
	
	private $knownTimeZones = 	array(
									'Pacific/Midway'    => "(GMT-11:00) Midway Island",
									'US/Samoa'          => "(GMT-11:00) Samoa",
									'US/Hawaii'         => "(GMT-10:00) Hawaii",
									'US/Alaska'         => "(GMT-09:00) Alaska",
									'US/Pacific'        => "(GMT-08:00) Pacific Time (US & Canada)",
								    'America/Tijuana'   => "(GMT-08:00) Tijuana",
								    'US/Arizona'        => "(GMT-07:00) Arizona",
								    'US/Mountain'       => "(GMT-07:00) Mountain Time (US & Canada)",
								    'America/Chihuahua' => "(GMT-07:00) Chihuahua",
								    'America/Mazatlan'  => "(GMT-07:00) Mazatlan",
								    'America/Mexico_City' => "(GMT-06:00) Mexico City",
								    'America/Monterrey' => "(GMT-06:00) Monterrey",
								    'Canada/Saskatchewan' => "(GMT-06:00) Saskatchewan",
								    'US/Central'        => "(GMT-06:00) Central Time (US & Canada)",
								    'US/Eastern'        => "(GMT-05:00) Eastern Time (US & Canada)",
								    'US/East-Indiana'   => "(GMT-05:00) Indiana (East)",
								    'America/Bogota'    => "(GMT-05:00) Bogota",
								    'America/Lima'      => "(GMT-05:00) Lima",
								    'America/Caracas'   => "(GMT-04:30) Caracas",
								    'Canada/Atlantic'   => "(GMT-04:00) Atlantic Time (Canada)",
								    'America/La_Paz'    => "(GMT-04:00) La Paz",
								    'America/Santiago'  => "(GMT-04:00) Santiago",
								    'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
								    'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
								    'Greenland'         => "(GMT-03:00) Greenland",
								    'Atlantic/Stanley'  => "(GMT-02:00) Stanley",
								    'Atlantic/Azores'   => "(GMT-01:00) Azores",
								    'Atlantic/Cape_Verde' => "(GMT-01:00) Cape Verde Is.",
								    'Africa/Casablanca' => "(GMT) Casablanca",
								    'Europe/Dublin'     => "(GMT) Dublin",
								    'Europe/Lisbon'     => "(GMT) Lisbon",
								    'Europe/London'     => "(GMT) London",
								    'Africa/Monrovia'   => "(GMT) Monrovia",
								    'Europe/Amsterdam'  => "(GMT+01:00) Amsterdam",
								    'Europe/Belgrade'   => "(GMT+01:00) Belgrade",
								    'Europe/Berlin'     => "(GMT+01:00) Berlin",
								    'Europe/Bratislava' => "(GMT+01:00) Bratislava",
								    'Europe/Brussels'   => "(GMT+01:00) Brussels",
								    'Europe/Budapest'   => "(GMT+01:00) Budapest",
								    'Europe/Copenhagen' => "(GMT+01:00) Copenhagen",
								    'Europe/Ljubljana'  => "(GMT+01:00) Ljubljana",
								    'Europe/Madrid'     => "(GMT+01:00) Madrid",
								    'Europe/Paris'      => "(GMT+01:00) Paris",
								    'Europe/Prague'     => "(GMT+01:00) Prague",
								    'Europe/Rome'       => "(GMT+01:00) Rome",
								    'Europe/Sarajevo'   => "(GMT+01:00) Sarajevo",
								    'Europe/Skopje'     => "(GMT+01:00) Skopje",
								    'Europe/Stockholm'  => "(GMT+01:00) Stockholm",
								    'Europe/Vienna'     => "(GMT+01:00) Vienna",
								    'Europe/Warsaw'     => "(GMT+01:00) Warsaw",
								    'Europe/Zagreb'     => "(GMT+01:00) Zagreb",
								    'Europe/Athens'     => "(GMT+02:00) Athens",
								    'Europe/Bucharest'  => "(GMT+02:00) Bucharest",
								    'Africa/Cairo'      => "(GMT+02:00) Cairo",
								    'Africa/Harare'     => "(GMT+02:00) Harare",
								    'Europe/Helsinki'   => "(GMT+02:00) Helsinki",
								    'Europe/Istanbul'   => "(GMT+02:00) Istanbul",
								    'Asia/Jerusalem'    => "(GMT+02:00) Jerusalem",
								    'Europe/Kiev'       => "(GMT+02:00) Kyiv",
								    'Europe/Minsk'      => "(GMT+02:00) Minsk",
								    'Europe/Riga'       => "(GMT+02:00) Riga",
								    'Europe/Sofia'      => "(GMT+02:00) Sofia",
								    'Europe/Tallinn'    => "(GMT+02:00) Tallinn",
								    'Europe/Vilnius'    => "(GMT+02:00) Vilnius",
								    'Asia/Baghdad'      => "(GMT+03:00) Baghdad",
								    'Asia/Kuwait'       => "(GMT+03:00) Kuwait",
								    'Europe/Moscow'     => "(GMT+03:00) Moscow",
								    'Africa/Nairobi'    => "(GMT+03:00) Nairobi",
								    'Asia/Riyadh'       => "(GMT+03:00) Riyadh",
								    'Europe/Volgograd'  => "(GMT+03:00) Volgograd",
								    'Asia/Tehran'       => "(GMT+03:30) Tehran",
								    'Asia/Baku'         => "(GMT+04:00) Baku",
								    'Asia/Muscat'       => "(GMT+04:00) Muscat",
								    'Asia/Tbilisi'      => "(GMT+04:00) Tbilisi",
								    'Asia/Yerevan'      => "(GMT+04:00) Yerevan",
								    'Asia/Kabul'        => "(GMT+04:30) Kabul",
								    'Asia/Yekaterinburg' => "(GMT+05:00) Ekaterinburg",
								    'Asia/Karachi'      => "(GMT+05:00) Karachi",
								    'Asia/Tashkent'     => "(GMT+05:00) Tashkent",
								    'Asia/Kolkata'      => "(GMT+05:30) Kolkata",
								    'Asia/Kathmandu'    => "(GMT+05:45) Kathmandu",
								    'Asia/Almaty'       => "(GMT+06:00) Almaty",
								    'Asia/Dhaka'        => "(GMT+06:00) Dhaka",
								    'Asia/Novosibirsk'  => "(GMT+06:00) Novosibirsk",
								    'Asia/Bangkok'      => "(GMT+07:00) Bangkok",
								    'Asia/Jakarta'      => "(GMT+07:00) Jakarta",
								    'Asia/Krasnoyarsk'  => "(GMT+07:00) Krasnoyarsk",
								    'Asia/Chongqing'    => "(GMT+08:00) Chongqing",
								    'Asia/Hong_Kong'    => "(GMT+08:00) Hong Kong",
								    'Asia/Irkutsk'      => "(GMT+08:00) Irkutsk",
								    'Asia/Kuala_Lumpur' => "(GMT+08:00) Kuala Lumpur",
								    'Australia/Perth'   => "(GMT+08:00) Perth",
								    'Asia/Singapore'    => "(GMT+08:00) Singapore",
								    'Asia/Taipei'       => "(GMT+08:00) Taipei",
								    'Asia/Ulaanbaatar'  => "(GMT+08:00) Ulaan Bataar",
								    'Asia/Urumqi'       => "(GMT+08:00) Urumqi",
								    'Asia/Seoul'        => "(GMT+09:00) Seoul",
								    'Asia/Tokyo'        => "(GMT+09:00) Tokyo",
								    'Asia/Yakutsk'      => "(GMT+09:00) Yakutsk",
								    'Australia/Adelaide' => "(GMT+09:30) Adelaide",
								    'Australia/Darwin'  => "(GMT+09:30) Darwin",
								    'Australia/Brisbane' => "(GMT+10:00) Brisbane",
								    'Australia/Canberra' => "(GMT+10:00) Canberra",
								    'Pacific/Guam'      => "(GMT+10:00) Guam",
								    'Australia/Hobart'  => "(GMT+10:00) Hobart",
								    'Australia/Melbourne' => "(GMT+10:00) Melbourne",
								    'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
								    'Australia/Sydney'  => "(GMT+10:00) Sydney",
								    'Asia/Vladivostok'  => "(GMT+10:00) Vladivostok",
								    'Asia/Magadan'      => "(GMT+11:00) Magadan",
								    'Pacific/Auckland'  => "(GMT+12:00) Auckland",
								    'Pacific/Fiji'      => "(GMT+12:00) Fiji",
								    'Asia/Kamchatka'    => "(GMT+12:00) Kamchatka",
								);
	
	/**
	* Öffnet die Installationsklasse und bestimmt, ob wir am Ende ein installationsfertige
	* Konfigurationsdatei besitzen möchten
	*
	* @param bool $install - Soll es installiert werden? [optional]
	**/
	public function __construct($install = true) {
		$this->knowConfigurations['INSTALLED'] = $install;
		$this->knowConfigurations['INSTALL_TIME'] = time();
	}	

	/**
	* Überprüft die System-Konfiguration und gibt eventuell Fehler zurück
	*
	* @return  bool - Entweder true oder eine Exception
	**/
	public function systemCheck() {
		// Die Konfigurations-Datei muss beschreibbar sein.
		if(!is_writable(ROOT_PATH.'/'.self::FILE))
			throw new \HumanException('Die Konfigurationsdatei „'.Install::FILE.'“ muss beschreibbar sein.');
		
		// Die PHP-Version muss größergleich self::REQUIERED_PHP_VERSION sein.
		$phpVersion =  	preg_replace('/^(\d+\.\d+\.\d+).*$/', '\\1',phpversion());
		if(version_compare($phpVersion,self::REQUIERED_PHP_VERSION,'<'))
			throw new \HumanException('Es wird mindestens die PHP-Version „'.self::REQUIERED_PHP_VERSION.'“ benötigt.');
		
		// MySQL muss installiert sein.
		if(!function_exists('mysql_connect'))
			throw new \HumanException('Es scheint kein MySQL auf diesem Server installiert zu sein.');
		
		// Das Cache-Verzeichnis muss beschreibar sein.
		if(!is_writable(ROOT_PATH.'/'.CacheFile::DIR))
			throw new \HumanException('Der Cache-Ordner „'.CacheFile::DIR.'“ muss beschreibbar sein.');
		
		// Die Allowed-Memory-Size muss größergleich self::REQUIERED_MEMORY_SIZE sein.
		if(calcBytes(ini_get('memory_limit')) < calcBytes(self::REQUIERED_MEMORY_SIZE))
			throw new \HumanException('Das Programm braucht mindestens '.Format::size(calcBytes(Install::REQUIERED_MEMORY_SIZE)).' Arbeitsspeicher.');
		
		return true;
	}
	
	/**
	* Gibt die Zeitzonen aus.
	*
	* @return array - Alle bekannten Zeitzonen
	**/
	public function getTimeZones() {
		return $this->knownTimeZones;
	}
	
	/**
	* Setzt die Zeitzone
	*
	* @param string $timezone - Ausgewählte Zeitzone
	**/
	public function setTimeZone($timezone) {
		$this->knowConfigurations['TIME_ZONE'] = $timezone;
	}
	
	/**
	* Überprüft eine Zeitzone auf validtät
	*
	* @return bool - Valid?
	**/
	public function checkTimeZone() {
		return isset($this->knownTimeZones[$this->knowConfigurations['TIME_ZONE']]);
	}
	
	/**
	* Setzt einen Zeitfaktor
	*
	* @param int $timefactor - Zeitfaktor
	**/
	public function setTimeFactor($timefactor) {
		$this->knowConfigurations['TIME_FACTOR'] = $timefactor;
	}
	
	/**
	* Überprüft den Zeitfaktor
	*
	* @return bool - false = Zeitfaktor muss ein Integerwert sein
	**/
	public function checkTimeFactor() {
		if($this->knowConfigurations['TIME_FACTOR'] != (int)$this->knowConfigurations['TIME_FACTOR']) return false;
		
		$this->knowConfigurations['TIME_FACTOR'] = (int)$this->knowConfigurations['TIME_FACTOR'];
		return true;
	}
	
	/**
	* Setzt Debug-Modus
	*
	* @param bool $debugMode - Ja/nein?
	**/
	public function setDebugMode($debugMode) {
		$this->knowConfigurations['DEBUG'] = $debugMode;
	}
	
	/**
	* Setzt die MySQL-Daten in der Konfiguration
	*
	* @param string $server - Der MySQL-Server
	* @param string $user - Der MySQL-User
	* @param string $pass - Das MySQL-User-Passwort
	* @param string $database - Die MySQL-Datenbank
	**/
	public function setMySQLData($server, $user, $pass, $database) {
		$this->knowConfigurations['MySQL']['SERVER'] = $server;
		$this->knowConfigurations['MySQL']['USER'] = $user;
		$this->knowConfigurations['MySQL']['PASS'] = $pass;
		$this->knowConfigurations['MySQL']['DATABASE'] = $database;
	}
	
	/**
	* Test eine MySQL-Verbindung mit den angegeben Daten
	*
	* @param bool $createDatabase - Wenn Datenbank nicht vorhanden, erstellen? [optional]
	* @return bool
	**/
	public function checkMySQLData($createDatabase=false) {
		try {
			$mysqlObject = new MySQL($this->knowConfigurations['MySQL']['SERVER'], $this->knowConfigurations['MySQL']['USER'], $this->knowConfigurations['MySQL']['PASS'],false,true);
		} catch (\Exception $exception) {
			throw new \HumanException('Der MySQL-Server erlaubt keinen Login mit den eingegeben Login-Daten.', -1, $exception);
		}
		
		if($createDatabase) $mysqlObject->createDatabase($this->knowConfigurations['MySQL']['DATABASE']);
		
		try {
			$mysqlObject->connectDatabase($this->knowConfigurations['MySQL']['DATABASE']);
		} catch (\Exception $exception) {
			if ($createDatabase) 
				throw new \HumanException('Die Datenbank konnte nicht erstellt werden. Hast du überhaupt genug Rechte?', -2, $exception);
				
			throw new \HumanException('Die angegebene Datenbank ist dem MySQL-Server nicht bekannt. Bitte erstelle sie zuerst oder erlaube mir, sie zu erstellen.', -3, $exception);
		}
		
		return true;
	}
	
	/**
	* Erstellt die in der SQL-Datei angegeben Tabellen ein.
	**/
	public function createMySQLTables() {
		$mysqlInstance = new MySQL($this->knowConfigurations['MySQL']['SERVER'], $this->knowConfigurations['MySQL']['USER'], $this->knowConfigurations['MySQL']['PASS'], $this->knowConfigurations['MySQL']['DATABASE'], false);
		
		if (!file_exists(ROOT_PATH.'/'.self::SQL_FILE)) throw new Exception('Keine SQL-Datei vorhanden.', 1050);
		$sql = file_get_contents(ROOT_PATH.'/'.self::SQL_FILE);
		
		$mysqlInstance->queries($sql);
	}
	
	/**
	* Schreibt die Konfiguration in die Konfigurationsdatei
	**/
	public function writeConfig() {
		date_default_timezone_set($this->knowConfigurations['TIME_ZONE']);
		
		$date = date('d.m.Y');
		$fileContent = <<<CONTENT
<?php
/**
*
* Konfiguration für diese Installation von TrainCompany
* Generiert am: {$date}
*
**/


CONTENT;
		
		// Namespace defininieren
		$fileContent .= "namespace Config {\n";
		foreach($this->knowConfigurations as $key=>$currentConfiguration) {
			if(!is_array($currentConfiguration)) {				
				$fileContent .= "\t".self::getConstString($key, $currentConfiguration);
			}
		}
		$fileContent .= "}\n\n";

		foreach($this->knowConfigurations as $key=>$currentConfiguration) {
			if(is_array($currentConfiguration)) {
				// Namespace defininieren
				$fileContent .= 'namespace Config\\'.$key." {\n";
				
				// Einzelne Elemente hinzufügen
				foreach($currentConfiguration as $key=>$value)
					$fileContent .= "\t".self::getConstString($key, $value);
					
				$fileContent .= "}\n\n";
			}
		}
		$fileContent .="?>";
	
		$handler = fopen(ROOT_PATH.'/'.self::FILE, 'w');
		fputs($handler, $fileContent);
		fclose($handler);
	}
	
	/**
	* Gibt einen Konstanten-String zurück.
	*
	* @param string $key - Name der Konstante
	* @param string $value - Inhalt der Konstante
	* @return string
	**/
	private static function getConstString($key, $value) {
		if(is_bool($value)) {
			if ($value) $valueString = 'true';
			else $value = 'false';
		} else if(is_numeric($value)) $valueString = $value;
		else $valueString = "'".$value."'";
			
		return "const ".$key." = ".$valueString.";\n";
	}
}
?>