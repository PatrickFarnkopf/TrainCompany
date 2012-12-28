<?php
/**
*
* Die Karte des Streckennetzes
* Datum: 5. November 2012
*
**/
namespace Script; class Modules_Game_Map_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Karte');
			
		$mapInstance = new \Game\Map(\Game\Station::getList(),\Game\Path::getList());
		$mapInstance->setWidth(700);
		
		$this->mi()->addVarCache('svgMap', $mapInstance->draw());
	}
	
}