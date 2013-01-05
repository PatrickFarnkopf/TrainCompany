<?php
/**
*
* F�gt alle Sub-Bibliotheken hinzu�
* Datum: 27. Juni 2012
*
**/

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
	// Alte Ausgaben rausl�schen
	while(!\Config\DEBUG && ob_get_level()) ob_end_clean();

	// Plain- oder HTML-Fehler ausgeben?
	if(class_exists('\Core\Header', false) && \Core\Header::existMainInstance() &&  \Core\Header::mainInstance()->getContentType() == 'text/html') {
		// Wenn nicht installiert, dann gebe eine besondere Fehlermeldung aus
		if(!\Config\INSTALLED)
			require ROOT_PATH.'templates/ExceptionInstallHTML.tpl.php';
		else
			require ROOT_PATH.'templates/ExceptionHTML.tpl.php';
	} else
		require ROOT_PATH.'templates/ExceptionPlain.tpl.php';
});

/**
* Gibt den definierten Exception-Handler zur�ck.
*
* @return callback
**/
function get_exception_handler() {
	// Den aktuellen abfragen
	$currentExceptionHandler = set_exception_handler(function(){});
	// Den aktuellen wieder setzen
	restore_exception_handler();
	// Exception-Handler zur�ckgeben
	return $currentExceptionHandler;
}

/**
* Dateien einbinde, die das Autoloading nicht �bernehmen kann. (Absolute Low-Level-Klassen.)
**/
require_once ROOT_PATH.'libary/Core/functions.php';
require_once ROOT_PATH.'libary/Core/Classname.class.php';
require_once ROOT_PATH.'libary/Core/Autoload.class.php';

/**
* Aktiviert das Autoloading von PHP.
**/
spl_autoload_register(function($classname) {
	// Klasse aufrufen
	new \Core\Autoload($classname);
});
?>