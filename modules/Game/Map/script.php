<?php
/**
*
* Die Karte des Streckennetzes
* Datum: 5. November 2012
*
**/
script {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Karte');
			
		$mapInstance = new \Game\Map(\Game\Station::getList(),\Game\Path::getList());
		$mapInstance->setWidth(700);
		
		$this->mi()->addVarCache('svgMap', $mapInstance->draw());
	}
	
}