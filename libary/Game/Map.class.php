<?php
/**
*
* Diese Klasse kann ein Karten-Bild als SVG-Grafik zeichnen.
* Datum: 6. November 2012
*
**/
namespace Game;

class Map {
	private $padding = 10;
	private $width = 700;
	private $height = false;
	private $selectable = false;
	private $maxRightStation = false;
	private $maxBottomStation = false;
	private $trainStations, $trainPaths, $svgContent;
	
	private $markedStations = [], $selectedStations = [], $selectedPaths = [];
	
	/**
	* Öffnet eine neue MapImage-Instanz und nimmt die Karten-Daten an
	*
	* @param array[Station] $trainStations - Alle Bahnhöfe auf der Karte
	* @param array[Path] $trainPaths - Alle Streckenstücke auf der Karte
	**/
	public function __construct(array $trainStations, array $trainPaths) {
		$this->trainStations = $trainStations;
		$this->trainPaths = $trainPaths;
	}
	
	/**
	* Karte anklickbar?
	*
	* @param bool $selectable - Anklickbar?
	**/
	public function setSelectable($selectable) {
		$this->selectable = $selectable;
	}
	
	/**
	* Setzt die hervorgehobenen Stationen
	*
	* @param array[Station] $selected - Ausgewählte Stationen
	* @param array[Station] $marked - Markierte Stationen
	**/
	public function setHighlightedStations(array $selected, array $marked) {
		$this->selectedStations = $selected;
		$this->markedStations = $marked;
	}
	
	/**
	* Setzt die markierten Strecken
	*
	* @param array[Path] $selectedPaths - Ausgewählte Strecken
	**/
	public function setSelectedPaths(array $selected) {
		$this->selectedPaths = $selected;
	}
	
	/**
	* Setzt den Breite der Karte.
	* 
	* @param int $width - Die Bereite
	**/
	public function setWidth($width) {
		$this->width = $width;
		
		$this->height = false;
		$this->maxRightStation = false;
		$this->maxBottomStation = false;
	}
	
	/**
	* Setzt den Padding der Karte.
	* 
	* @param int $padding - Der Padding
	**/
	public function setPadding($padding) {
		$this->padding = $padding;
	}
	
	/**
	* Das Element, das am weitesten rechts ist.
	*
	* @return Station - Rechtes Element
	**/
	private function getMaxRightStation() {
		if($this->maxRightStation !== false) return $this->maxRightStation;
	
		$maxRight = 0;
		foreach($this->trainStations as $currentStation) {
			if($currentStation->getX() > $maxRight) {
				$this->maxRightStation = $currentStation;
				$maxRight = $currentStation->getX();
			}
		}
		
		return $this->maxRightStation;
	}
	
	/**
	* Das Element, das am weitesten unten ist.
	*
	* @return Station - Unteres Element
	**/
	private function getMaxBottomStation() {
		if($this->maxBottomStation !== false) return $this->maxBottomStation;
	
		$maxBottom = 0;
		foreach($this->trainStations as $currentStation) {
			if($currentStation->getY() > $maxBottom) {
				$this->maxBottomStation = $currentStation;
				$maxBottom = $currentStation->getY();
			}
		}
		
		return $this->maxBottomStation;
	}
	
	/**
	* Gibt die Höhe der Karte zurück
	*
	* @return int - Höhe
	**/
	public function getHeight() {
		if($this->height !== false) $this->height;
		
		$this->height = $this->calcValue($this->getMaxBottomStation()->getY()) + $this->padding;
		
		return $this->height;
	}
	
	/**
	* Berechnet den Skalierungsfaktor
	*
	* @return float - Skalierungsfaktor
	**/
	private function calcFactor() {
		return $this->getMaxRightStation()->getX() / ($this->width - 2*$this->padding);
	}
	
	/**
	* Skaliert die X-/Y-Werte
	*
	* @param int $value - Der X-/Y-Wert
	* @return int - Der skalierte Wert
	**/
	private function calcValue($value) {
		$factor = $this->calcFactor();
		
		return round($value / $factor + $this->padding);
	}
	
	/**
	* Zeichnet einen Bahnhof auf die Karte.
	*
	* @param Station $station - Der Bahnhof, der gemalt werden soll.
	**/
	private function drawStation(Station $station) {
		$titleString = \Core\i::Module()->getTemplateContent('currentStation',['station'=>$station]);
		
		$titleString = \Core\Format::string($titleString);
		
		$additionString = 'id="stationID'.$station->getID().'"';
		if($this->selectable)
			$additionString .= ' onclick="marker(evt)"';
		
		$stationClass = '';
		if(in_array($station, $this->selectedStations))
			$stationClass .= ' StationSelected';
		if(in_array($station, $this->markedStations))
			$stationClass .= ' StationMarked';
		
		$stationRadius = 0;
		switch($station->getGroup()) {
			case Station::GROUP_BIG:
				$stationClass .= ' StationBig';
				$stationRadius = 6;
				break;
			case Station::GROUP_MIDDLE:
				$stationClass .= ' StationMiddle';
				$stationRadius = 3;
				break;
			case Station::GROUP_SMALL:
				$stationClass .= ' StationSmall';
				$stationRadius = 2;
				break;
		}
		
		$this->svgContent .= '<circle title="'.$titleString.'" class="'.$stationClass.'" rel="tooltip" cx="'.$this->calcValue($station->getX()).'" cy="'.$this->calcValue($station->getY()).'" r="'.$stationRadius.'" '.$additionString.' />';
		$this->svgContent .= "\n";
	}
	
	/**
	* Zeichnet eine Verbindung zwischen zwei Bahnhöfen auf die Karte
	*
	* @param Path $path - Strecke
	**/
	private function drawPath(Path $path) {
		$stepVectors = $path->getStepVectors();
		$stepVectorString = '';
		
		foreach($stepVectors as $currentVector)	$stepVectorString.= ' '.$this->calcValue($currentVector[0]).','.$this->calcValue($currentVector[1]);
		
		$pathDescription = \Core\i::Module()->getTemplateContent('currentPath',['path'=>$path]);
		
		// Klasse des Pfades?
		$pathClass = '';
		
		if(!$path->isEletrified())
			$pathClass .= ' NotElectrified';
		
		if(in_array($path, $this->selectedPaths))
			$pathClass .= ' PathSelected';
		
		switch($path->getGroup()) {
			case Path::GROUP_MAIN:
				$pathClass .= ' PathMain';
				break;
			case Path::GROUP_SMALL:
				$pathClass .= ' PathSmall';
				break;
		}
		
		$this->svgContent .= '<polyline points="'.$stepVectorString.'" class="'.$pathClass.'" onclick="lineClick(\''.\Core\Format::string($pathDescription).'\')" />';
		$this->svgContent .= "\n";
	}
	
	
	/**
	* Zeichnet die gesammte Karte und gibt die SVG-Daten zurück.
	*
	* @return string - Die SVG-Daten
	**/
	public function draw() {
		$mapWidth = $this->width;
		$mapHeight = $this->getHeight();
		
		$this->svgContent = <<<HEADER
<svg
     version="1.1" baseProfile="full"
     width="{$mapWidth}px" height="{$mapHeight}px">
  
HEADER;

		foreach($this->trainPaths as $currentPath) $this->drawPath($currentPath);
		foreach($this->trainStations as $currentStation) $this->drawStation($currentStation);
		
		$this->svgContent .= "</svg>";
		
		return $this->svgContent;
	}
}