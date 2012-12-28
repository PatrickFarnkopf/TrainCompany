<?php
/**
*
* Dummy-Konfigurations-Datei. Startet automatisch den Installations-Prozess.
*
**/

namespace Config {
	const INSTALLED = false;
	const INSTALL_TIME = 0;
	const DEBUG = true;
	const TIME_ZONE = 'Europe/Berlin';
}

namespace Config\Version {
	const STRING = '0.7.0';
	const LICENSE_FILE = '/docs/license.txt';
}

namespace Config\MySQL {
	const SERVER = NULL;
	const USER = NULL;
	const PASS = NULL;
	const DATABASE = 'traincompany';
}

?>