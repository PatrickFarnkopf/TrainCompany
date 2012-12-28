<?php
/**
*
* Oberfläche zur Änderung von Userdaten
* Datum: 18. Oktober 2012
*
**/
namespace Script; class Modules_Game_Settings_script_php extends \Core\Module\Extender  {
	public function __construct() {
		\Core\Module::goToModule('Game_Settings_General');
	}
}
?>