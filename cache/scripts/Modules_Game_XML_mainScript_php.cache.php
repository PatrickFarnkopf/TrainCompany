<?php
/**
*
* Hauptklasse für XML-Requests. Setzt das Template-Set auf XML
* Datum: 19. November 2012
*
**/

namespace Script; class Modules_Game_XML_mainScript_php extends \Core\Module\Extender  {
	public function __construct() {
		// Template-Set umstellen
		$this->mi()->setTemplateSet('xml');
	}
}