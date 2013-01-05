<?php
/**
*
* Eine Sammlung an Formatierungsfunktionen
* Datum: 24. Oktober 2012
*
**/
namespace Core;

class Format {
	/**
	* Formatiert ein Datum
	*	
	* @param int $time
	* @param bool $passed
	* @return string
	*/
	public static function date($time, $withSecs = false, $passed = true, $long = false) {
	    // Gestriges Datum herausfinden
	    $date = explode('.', date('Y.m.d', time()-86400));
	    // Gestriges Timestamp berechnen
	    $yesterdayTime = mktime(0,0,0,$date[1], $date[2], $date[0]);

	    // Morgiges Datum herausfinden
	    $date = explode('.', date('Y.m.d', time()+86400));
	    // Morgiger Timestamp berechnen
	    $tomorrowTime = mktime(0,0,0,$date[1], $date[2], $date[0]);

	    $dateString = date('d.m.'.($long ? 'Y' : ''), $time);
	    if($withSecs) $timeString = date('H:i:s', $time);
	    else $timeString = date('H:i', $time);

	    // Unbekannt?
	    if($time == 0) return 'unbekannt';

	    // Schon vorbei?
	    if($time < time() && $passed) return 'Zeit schon abgelaufen';

	    // Heute?
	    if($time < $tomorrowTime && $yesterdayTime + 86400 < $time) return 'heute, '.($long?'um ':'').$timeString.' Uhr';

	    // Morgen?
	    if($time < $tomorrowTime + 86400 && $time > time()) return 'morgen, '.($long?'um ':'').$timeString.' Uhr';

	    return 'am '.$dateString.', '.($long?'um ':'').$timeString.' Uhr';
	}

	/**
 	* Formatiert einen Nummer
 	*
 	* @param int,float $number
 	* @param int $decimals
 	* @return string
 	**/
 	public static function number($number,$decimals=0) {
 		$pre = $number > 0 && round($number, 2) == 0 ? '>' : '';

    	return $pre.number_format($number, $decimals, ',', '.');
    }
    
    /**
    * Formiert einen String
    *
    * @param String $string
    * @return String
    **/
    public static function string($string) {
    	// Sonderzeichen bitte nicht maskieren
		return htmlspecialchars($string, ENT_COMPAT | ENT_HTML5, 'UTF-8', false);   
    }
    
    /**
    * Formatiert einen Prozent-Wert
    *
    * @param float $floatValue - Der Wert
    * @return string
    **/
    public static function percent($floatValue) {
	    return self::unit(self::number($floatValue*100),'%');
    }
    
    /**
    * Formatiert eine Datei-Größe
    *
    * @param int $fileSize - Die Datei-Größe
    * @return string - Formatierter String
    **/
    public static function size($fileSize) {
    	$sizes = array('B','KiB','MiB','GiB','TiB','PiB');
    	
    	foreach($sizes as $key=>$currentSize) {
	    	if($fileSize >= pow(2,10*($key+1))) continue;
	    	
		    $fileSize /= pow(2,10*$key);
		    return self::unit(self::number($fileSize,2),$currentSize);
		    
    	}
    }
    
    /**
    * Formatiert eine Zahl mit Einheit.
    *
    * @param string $value - Zahl
    * @param string $unit - Einheit
    * @return string - Formatierter String
    **/
    public static function unit($value, $unit) {
	    return $value.'&thinsp;'.$unit;
    }
}
?>