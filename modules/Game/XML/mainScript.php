<?php
/**
*
* Hauptklasse für XML-Requests. Setzt das Template-Set auf XML
* Datum: 19. November 2012
*
**/

script {
	public function __construct() {
		// Template-Set umstellen
		$this->mi()->setTemplateSet('xml');
	}
}