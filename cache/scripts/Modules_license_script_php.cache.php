<?php
/**
*
* Die Klasse des Lizenz-Modules
* Datum: 24. Oktober 2012
*
**/
namespace Script; class Modules_license_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		
		$this->mi()->addVarCache('siteTitle', 'Lizenz');
		
		$licenseText = file_get_contents(ROOT_PATH.\Config\Version\LICENSE_FILE);
		$this->mi()->addVarCache('licenseText', $licenseText);
		
		$this->mi()->addVarCache('versionsString', \Config\Version\STRING);		
	}
}