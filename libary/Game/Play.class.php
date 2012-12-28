<?php
/**
*
* Verwaltet die Züge.
* Datum: 24. Oktober 2012
*
**/
namespace Game;

class Play {
	const SEASON_DURRATION = 259200; // Dauer einer Jahreszeiten in Sekunden. 604.800 Sekunden = 7 Tage
	const START_YEAR = 2013;
	
	/**
	* Gibt die Länge einer Jahreszeit zurück.
	*
	* @return int - Jahreszeitenlänge
	**/
	public static function getSeasonDurration() {
		return self::SEASON_DURRATION;
	}
	
	/**
	* Berechnet das aktuelle Jahr und die aktuelle Jahreszeit
	* 
	* @return array('currentYear' => $currentYear, 'currentSeason' => $currentSeason)
	**/
	public static function getCurrentSeasonAndYear() {
		$timeSinceStart = time() - \Config\INSTALL_TIME;

		$seasonsSinceStart = floor($timeSinceStart / self::getSeasonDurration());
		$yearsSinceStart = floor($seasonsSinceStart / Season::countObjects());
		
		$currentYear = self::START_YEAR + $yearsSinceStart;
		$currentSeason = $seasonsSinceStart - ($yearsSinceStart * Season::countObjects());
		
		return array('currentYear' => $currentYear, 'currentSeason' => $currentSeason);
	}
	
	/**
	* Gibt die ID der aktuellen Jahreszeit aus.
	*
	* @return int - Jahreszeit
	**/
	public static function getCurrentSeasonID() {
		return self::getCurrentSeasonAndYear()['currentSeason'];
	}
	
	/**
	* Gibt das aktuelle Jahr und die aktuelle Jahreszeit als String zurück.
	*
	* @return string - z.B.: "Winter 2012"
	**/
	public static function getCurrentSeasonAndYearString() {
		$currentDate = self::getCurrentSeasonAndYear();
		$currentSeasonsAsString = Season::getObjectForID($currentDate['currentSeason'])->getName();
		
		return $currentSeasonsAsString.' '.$currentDate['currentYear'];
	}
	
		
	/**
	* Berechnet die Zeit bis zum nächsten Jahreszeitenwechsel
	*
	* @return int - Zeit bis zum nächsten Jahreszeitenwechsel in Sekunden
	**/
	public static function timeTillNextSeason() {
		$timeSinceStart = time() - \Config\INSTALL_TIME;

		$seasonsSinceStart = $timeSinceStart / self::getSeasonDurration();
		$FullSeasonsSinceStart = floor($seasonsSinceStart);
		
		$currentSeason = $seasonsSinceStart - $FullSeasonsSinceStart;
		
		return self::getSeasonDurration() - self::getSeasonDurration()*$currentSeason;
	}
	
	/**
	* Berechnet, wie viele Jahre etwas alt ist
	*
	* @param int $time - Zum Beispiel eine Kaufzeit
	* @return int - Das alter in Jahren
	**/
	public static function calcYearsSinceTime($time) {
		$timeSinceTime = time() - $time;

		$seasonsSinceTime = floor($timeSinceTime / self::getSeasonDurration());
		return floor($seasonsSinceTime / Season::countObjects());
	}
}
?>