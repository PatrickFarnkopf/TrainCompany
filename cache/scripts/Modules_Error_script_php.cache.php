<?php
/**
*
* Darstellung eines 404-Fehlers
* Datum: 23. Dezember 2012
*
**/
namespace Script; class Modules_Error_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$moduleInstance = \Core\i::Module();
		$options = $moduleInstance->getVarCache('options');
		
		$moduleInstance->addVarCache('siteTitle', 'Fehler 404');
		
		// Entsprechenden Header senden
		\Core\i::Header()->addStatus(404);
	}

}
?>