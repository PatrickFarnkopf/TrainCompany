<?php
/**
*
* Die Spiele-Klasse
* Datum: 17. Oktober 2012
*
**/
namespace Script; class Modules_Game_script_php extends \Core\Module\Extender  {
	public function __construct() {
		\Core\Module::goToModule('Game_Overview');
	}
}
?>