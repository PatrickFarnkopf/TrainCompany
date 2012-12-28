<?php
/**
*
* FŸgt alle Sub-Bibliotheken hinzuÉ
* Datum: 27. Juni 2012
*
**/

/**
* Dateien einbinde, die das Autoloading nicht Ÿbernehmen kann. (Absolute Low-Level-Klassen.)
**/
require_once ROOT_PATH.'libary/Core/functions.php';
require_once ROOT_PATH.'libary/Core/Classname.class.php';
require_once ROOT_PATH.'libary/Core/Alias.class.php';
require_once ROOT_PATH.'libary/Core/Autoload.class.php';

/**
* PHP-Fehler sollen Exceptions werfen.
**/
set_error_handler(function($number, $string, $file, $line) {
	// Eine Exception werfen.
	throw new \ErrorException($string, 0, $number, $file, $line);
}, E_ALL);

/**
* Unabgefanene Exceptions sollen hier landen.
**/
set_exception_handler(function(Exception $exception) {
	// Alte Ausgaben rauslšschen
	while(ob_get_level()) ob_end_clean();

	// Plain- oder HTML-Fehler ausgeben?
	if(class_exists('\Core\Header', false) && \Core\i::Header()->getContentType() == 'text/html')
		require ROOT_PATH.'templates/ExceptionHTML.tpl.php';
	else
		require ROOT_PATH.'templates/ExceptionPlain.tpl.php';
});

/**
* Aktiviert das Autoloading von PHP.
**/
spl_autoload_register(function($classname) {
	// Klasse aufrufen
	new \Core\Autoload($classname);
});
?>