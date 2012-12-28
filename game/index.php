<?php
/**
*
* Diese Datei lŠdt die Bibliothek und startet das Programm.
* Datum: 27. Juni 2012
*
**/
// Grund-Konstanten definieren
define("ROOT_PATH", __DIR__.'/../');

// Konfigurations-Datei einbinden
require_once ROOT_PATH.'config.inc.php';
// Die Bibliothek einbinden. (Oder besser gesagt, ihre Autoload-Funktion.)
require_once ROOT_PATH.'libary/main.inc.php';

// Das Spiel starten.
\Game\Main::startAll();

// Am Ende der AusfŸrhung angekommen
exit;
?>