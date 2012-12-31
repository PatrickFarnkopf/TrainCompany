<?php
/**
*
* Diese Datei lädt die Bibliothek und startet das Programm.
* Datum: 27. Juni 2012
*
**/
// Grund-Konstanten definieren
define("ROOT_PATH", __DIR__.'/../');

// Konfigurations-Datei einbinden
if(file_exists(ROOT_PATH.'config.inc.php')) require_once ROOT_PATH.'config.inc.php';
else require_once ROOT_PATH.'config.sample.inc.php';

// Die Bibliothek einbinden. (Oder besser gesagt, ihre Autoload-Funktion.)
require_once ROOT_PATH.'libary/main.inc.php';

// Das Spiel starten.
\Daemon\Main::startAll();

// Am Ende der Ausführung angekommen
exit;
?>