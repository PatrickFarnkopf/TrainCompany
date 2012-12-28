<?php
/**
*
* Jahreszeiten-Daten, die in die Jahreszeiten-Klasse geladen werden.
* Datum: 31. Oktober 2012
*
**/
use \Game\Season;

$newSeason = new Season('Frühling');
$newSeason->setRubbingFactor(0.8);
Season::addObject(0, $newSeason);

$newSeason = new Season('Sommer');
$newSeason->setRubbingFactor(0.8);
Season::addObject(1, $newSeason);

$newSeason = new Season('Herbst');
$newSeason->setRubbingFactor(0.6);
Season::addObject(2, $newSeason);

$newSeason = new Season('Winter');
$newSeason->setRubbingFactor(0.7);
Season::addObject(3, $newSeason);
?>