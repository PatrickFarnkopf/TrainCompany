<?php
/**
*
* Strecken-Daten, die in die Path-Klasse eingefügt werden.
* Datum: 6. November 2012
*
**/
use \Game\Path;

/**
* Linke Rheinstrecke (Köln-Mainz)
**/
$newPath = new Path();
$newPath->setStartStation(0);
$newPath->setEndStation(1);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(34);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(0, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(1);
$newPath->setEndStation(2);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(20);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(1, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(2);
$newPath->setEndStation(3);
$newPath->setTwistingFactor(0.55);
$newPath->setLength(21);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(2, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(3);
$newPath->setEndStation(4);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(18);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(3, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(4);
$newPath->setEndStation(5);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(61);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(4, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(5);
$newPath->setEndStation(6);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(30);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(5, $newPath, Path::GROUP_MAIN);

/**
* Schnellfahrstrecke FF-Flughafen <-> Köln Messe/Deutz
**/
$newPath = new Path();
$newPath->setStartStation(8);
$newPath->setEndStation(10);
$newPath->setTwistingFactor(0.1);
$newPath->setLength(59);
$newPath->setMaxSpeed(300);
$newPath->setElectrified(true);
Path::addObject(6, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(10);
$newPath->setEndStation(11);
$newPath->setTwistingFactor(0.1);
$newPath->setLength(21);
$newPath->setMaxSpeed(300);
$newPath->setElectrified(true);
Path::addObject(7, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(11);
$newPath->setEndStation(12);
$newPath->setTwistingFactor(0.1);
$newPath->setLength(65);
$newPath->setMaxSpeed(300);
$newPath->setElectrified(true);
Path::addObject(8, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(12);
$newPath->setEndStation(13);
$newPath->setTwistingFactor(0.1);
$newPath->setLength(23);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(9, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Köln–Duisburg
**/
$newPath = new Path();
$newPath->setStartStation(0);
$newPath->setEndStation(13);
$newPath->setTwistingFactor(0.1);
$newPath->setLength(1);
$newPath->setMaxSpeed(40);
$newPath->setElectrified(true);
Path::addObject(10, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(13);
$newPath->setEndStation(14);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(35);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(11, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(14);
$newPath->setEndStation(81);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(22);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(91, $newPath, Path::GROUP_MAIN);

/**
* Mainbahn (Mainz-Frankfurt)
**/
$newPath = new Path();
$newPath->setStartStation(6);
$newPath->setEndStation(7);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(12);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(12, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(7);
$newPath->setEndStation(8);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(16);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(13, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(8);
$newPath->setEndStation(9);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(11);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(14, $newPath, Path::GROUP_MAIN);

/**
* Riedbahn (Mannheim-Frankfurt, auch FF Flughafen)
**/
$newPath = new Path();
$newPath->setStartStation(15);
$newPath->setEndStation(17);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(28);
$newPath->setMaxSpeed(180);
$newPath->setElectrified(true);
Path::addObject(15, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(17);
$newPath->setEndStation(16);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(26);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(16, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(16);
$newPath->setEndStation(9);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(26);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(17, $newPath, Path::GROUP_MAIN);

$newPath = new Path(); // Abzweig nach FF Flughafen
$newPath->setStartStation(16);
$newPath->setEndStation(8);
$newPath->setTwistingFactor(0.5);
$newPath->setLength(18);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(18, $newPath, Path::GROUP_MAIN);

$newPath = new Path(); // Abzweig von Biblis nach Worms
$newPath->setStartStation(17);
$newPath->setEndStation(19);
$newPath->setTwistingFactor(0.45);
$newPath->setLength(10);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(22, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Mainz–Ludwigshafen (Start in Mannheim)
**/
$newPath = new Path();
$newPath->setStartStation(15);
$newPath->setEndStation(18);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(13);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(19, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(18);
$newPath->setEndStation(19);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(11);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(20, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(19);
$newPath->setEndStation(6);
$newPath->setTwistingFactor(0.15);
$newPath->setLength(46);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(21, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Freinsheim–Frankenthal
**/

$newPath = new Path();
$newPath->setStartStation(20);
$newPath->setEndStation(18);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(13);
$newPath->setMaxSpeed(100);
$newPath->setElectrified(false);
Path::addObject(23, $newPath, Path::GROUP_SMALL);

/**
* Pfälzische Nordbahn (Abschnitt Neustadt - Grünstadt)
**/

$newPath = new Path();
$newPath->setStartStation(37);
$newPath->setEndStation(41);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(15); 
$newPath->setMaxSpeed(100);
$newPath->setElectrified(false);
Path::addObject(38, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(41);
$newPath->setEndStation(20);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(6); // Eigentlich 6
$newPath->setMaxSpeed(100);
$newPath->setElectrified(false);
Path::addObject(39, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(20);
$newPath->setEndStation(21);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(9);
$newPath->setMaxSpeed(100);
$newPath->setElectrified(false);
Path::addObject(24, $newPath, Path::GROUP_SMALL);

/**
* Nahetalbahn (Bingen - Saarbrücken)
**/
$newPath = new Path();
$newPath->setStartStation(5);
$newPath->setEndStation(31);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(15);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(false);
Path::addObject(25, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(31);
$newPath->setEndStation(32);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(5);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(false);
Path::addObject(26, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(32);
$newPath->setEndStation(33);
$newPath->setTwistingFactor(0.5);
$newPath->setLength(48);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(false);
Path::addObject(27, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(33);
$newPath->setEndStation(34);
$newPath->setTwistingFactor(0.5);
$newPath->setLength(26);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(false);
Path::addObject(28, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(34);
$newPath->setEndStation(35);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(29);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(29, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(35);
$newPath->setEndStation(22);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(21);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(30, $newPath, Path::GROUP_SMALL);

/**
* Pfälzische Ludwigsbahn (Mannheim–Saarbrücken)
**/

$newPath = new Path();
$newPath->setStartStation(15);
$newPath->setEndStation(36);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(13);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(31, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(36);
$newPath->setEndStation(37);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(17);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(32, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(37);
$newPath->setEndStation(38);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(34);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(33, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(38);
$newPath->setEndStation(39);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(35);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(34, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(39);
$newPath->setEndStation(40);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(15);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(35, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(40);
$newPath->setEndStation(22);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(16);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(36, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Homburg–Neunkirchen
**/

$newPath = new Path();
$newPath->setStartStation(39);
$newPath->setEndStation(35);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(14);
$newPath->setMaxSpeed(130);
$newPath->setElectrified(true);
Path::addObject(37, $newPath, Path::GROUP_SMALL);

/**
* Saarstrecke (Saarbrücken-Trier)
**/

$newPath = new Path();
$newPath->setStartStation(22);
$newPath->setEndStation(42);
$newPath->setTwistingFactor(0.45);
$newPath->setLength(24);
$newPath->setMaxSpeed(110);
$newPath->setElectrified(true);
Path::addObject(40, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(42);
$newPath->setEndStation(43);
$newPath->setTwistingFactor(0.45);
$newPath->setLength(27);
$newPath->setMaxSpeed(110);
$newPath->setElectrified(true);
Path::addObject(41, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(43);
$newPath->setEndStation(44);
$newPath->setTwistingFactor(0.45);
$newPath->setLength(32);
$newPath->setMaxSpeed(110);
$newPath->setElectrified(true);
Path::addObject(42, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(44);
$newPath->setEndStation(23);
$newPath->setTwistingFactor(0.45);
$newPath->setLength(16);
$newPath->setMaxSpeed(110);
$newPath->setElectrified(true);
Path::addObject(43, $newPath, Path::GROUP_MAIN);

/**
* Moselstrecke (Koblenz-Trier)
**/

$newPath = new Path();
$newPath->setStartStation(4);
$newPath->setEndStation(46);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(60);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(44, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(46);
$newPath->setEndStation(45);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(17);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(45, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(45);
$newPath->setEndStation(23);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(17);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(46, $newPath, Path::GROUP_MAIN);

/**
* Eifelstrecke (Köln-Trier)
**/

$newPath = new Path();
$newPath->setStartStation(0);
$newPath->setEndStation(50);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(22);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(false);
Path::addObject(47, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(50);
$newPath->setEndStation(49);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(29);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(false);
Path::addObject(48, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(49);
$newPath->setEndStation(48);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(71);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(false);
Path::addObject(49, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(48);
$newPath->setEndStation(47);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(30);
$newPath->setMaxSpeed(90);
$newPath->setElectrified(false);
Path::addObject(50, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(47);
$newPath->setEndStation(23);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(37);
$newPath->setMaxSpeed(80);
$newPath->setElectrified(false);
Path::addObject(51, $newPath, Path::GROUP_SMALL);

/**
* Lahntalbahn (Koblenz-Wetzlar)
**/
$newPath = new Path();
$newPath->setStartStation(4);
$newPath->setEndStation(54);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(25);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(false);
Path::addObject(52, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(54);
$newPath->setEndStation(53);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(26);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(false);
Path::addObject(53, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(53);
$newPath->setEndStation(52);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(29);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(false);
Path::addObject(54, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(52);
$newPath->setEndStation(51);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(23);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(false);
Path::addObject(55, $newPath, Path::GROUP_SMALL);

/**
* SFS Hannover-Würzburg (Abschnitt Kassel-Würzburg)
**/
$newPath = new Path();
$newPath->setStartStation(26);
$newPath->setEndStation(25);
$newPath->setTwistingFactor(0.05);
$newPath->setLength(90);
$newPath->setMaxSpeed(280);
$newPath->setElectrified(true);
Path::addObject(56, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(25);
$newPath->setEndStation(75);
$newPath->setTwistingFactor(0.05);
$newPath->setLength(93);
$newPath->setMaxSpeed(280);
$newPath->setElectrified(true);
Path::addObject(57, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(75);
$newPath->setEndStation(24);
$newPath->setTwistingFactor(0.05);
$newPath->setLength(93);
$newPath->setMaxSpeed(280);
$newPath->setElectrified(true);
Path::addObject(83, $newPath, Path::GROUP_MAIN);

/**
* Dill-Strecke (Siegen-Gießen)
**/
$newPath = new Path();
$newPath->setStartStation(55);
$newPath->setEndStation(57);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(26);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(58, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(57);
$newPath->setEndStation(56);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(12);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(59, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(56);
$newPath->setEndStation(51);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(23);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(60, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(51);
$newPath->setEndStation(30);
$newPath->setTwistingFactor(0.6);
$newPath->setLength(13);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(61, $newPath, Path::GROUP_SMALL);

/**
* Main-Weser-Bahn (Kassel-Frankfurt)
**/
$newPath = new Path();
$newPath->setStartStation(26);
$newPath->setEndStation(66);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(14);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(62, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(66);
$newPath->setEndStation(65);
$newPath->setTwistingFactor(0.5);
$newPath->setLength(20);
$newPath->setMaxSpeed(110);
$newPath->setElectrified(true);
Path::addObject(63, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(65);
$newPath->setEndStation(64);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(28);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(64, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(64);
$newPath->setEndStation(63);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(27);
$newPath->setMaxSpeed(130);
$newPath->setElectrified(true);
Path::addObject(65, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(63);
$newPath->setEndStation(60);
$newPath->setTwistingFactor(0.5);
$newPath->setLength(15);
$newPath->setMaxSpeed(130);
$newPath->setElectrified(true);
Path::addObject(66, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(60);
$newPath->setEndStation(59);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(8);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(67, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(59);
$newPath->setEndStation(30);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(22);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(68, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(30);
$newPath->setEndStation(61);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(28);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(69, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(61);
$newPath->setEndStation(58);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(4);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(70, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(58);
$newPath->setEndStation(62);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(18);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(71, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(62);
$newPath->setEndStation(9);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(18);
$newPath->setMaxSpeed(150);
$newPath->setElectrified(true);
Path::addObject(72, $newPath, Path::GROUP_MAIN);

/**
* Südmainische Strecke von Frankfurt nach Hanau
**/
$newPath = new Path();
$newPath->setStartStation(9);
$newPath->setEndStation(67);
$newPath->setTwistingFactor(0.5);
$newPath->setLength(10);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(73, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(67);
$newPath->setEndStation(68);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(13);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(74, $newPath, Path::GROUP_MAIN);

/**
* Kinzigtalbahn (Hessen) (Fulda-Hanau)
**/

$newPath = new Path();
$newPath->setStartStation(25);
$newPath->setEndStation(72);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(18);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(75, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(72);
$newPath->setEndStation(71);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(10);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(76, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(71);
$newPath->setEndStation(70);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(20);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(77, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(70);
$newPath->setEndStation(69);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(11);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(78, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(69);
$newPath->setEndStation(68);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(21);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(79, $newPath, Path::GROUP_MAIN);

/**
* Siegstrecke (Siegburg/Bonn-Siegen)
**/
$newPath = new Path();
$newPath->setStartStation(12);
$newPath->setEndStation(74);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(19);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(80, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(74);
$newPath->setEndStation(73);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(40);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(81, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(73);
$newPath->setEndStation(55);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(26);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(82, $newPath, Path::GROUP_MAIN);

/**
* Main-Spessart-Bahn (Abschnitt Hanau - Gemünden (Main) (einschließlich))
**/
$newPath = new Path();
$newPath->setStartStation(68);
$newPath->setEndStation(76);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(23);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(84, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(76);
$newPath->setEndStation(77);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(38);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(85, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(77);
$newPath->setEndStation(98);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(14);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(111, $newPath, Path::GROUP_SMALL);

$newPath = new Path(); // Einschlielich Natenbacher Kurve
$newPath->setStartStation(77);
$newPath->setEndStation(75);
$newPath->setTwistingFactor(0.45);
$newPath->setLength(14);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(86, $newPath, Path::GROUP_MAIN);


/**
* Bahnstrecke Nürnberg-Bamberg
**/
$newPath = new Path();
$newPath->setStartStation(28);
$newPath->setEndStation(78);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(8);
$newPath->setMaxSpeed(90);
$newPath->setElectrified(true);
Path::addObject(87, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(78);
$newPath->setEndStation(94);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(16);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(114, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(94);
$newPath->setEndStation(95);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(42);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(115, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Fürth - Nürnberg
**/
$newPath = new Path();
$newPath->setStartStation(78);
$newPath->setEndStation(79);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(33);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(88, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(79);
$newPath->setEndStation(80);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(29);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(89, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(80);
$newPath->setEndStation(24);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(33);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(90, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Duisburg - Dortmund
**/
$newPath = new Path();
$newPath->setStartStation(81);
$newPath->setEndStation(82);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(19);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(92, $newPath, Path::GROUP_MAIN);	

$newPath = new Path();
$newPath->setStartStation(82);
$newPath->setEndStation(83);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(17);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(93, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(83);
$newPath->setEndStation(27);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(19);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(94, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Dortmund - Hamm
**/
$newPath = new Path();
$newPath->setStartStation(27);
$newPath->setEndStation(84);
$newPath->setTwistingFactor(0.2);
$newPath->setLength(19);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(95, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Wuppertal - Köln
**/
$newPath = new Path();
$newPath->setStartStation(86);
$newPath->setEndStation(85);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(18);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(96, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(85);
$newPath->setEndStation(13);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(27);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(97, $newPath, Path::GROUP_MAIN);
	
/**
* Bahnstrecke Dortmund - Wupertal
**/
$newPath = new Path();
$newPath->setStartStation(27);
$newPath->setEndStation(87);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(31);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(98, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(87);
$newPath->setEndStation(86);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(26);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(99, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Wuppertal - Düsseldorf
**/
$newPath = new Path();
$newPath->setStartStation(86);
$newPath->setEndStation(14);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(27);
$newPath->setMaxSpeed(130);
$newPath->setElectrified(true);
Path::addObject(100, $newPath, Path::GROUP_SMALL);

/**
* Bahnstrecke Hagen - Hamm
**/
$newPath = new Path();
$newPath->setStartStation(87);
$newPath->setEndStation(84);
$newPath->setTwistingFactor(0.3);
$newPath->setLength(48);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(101, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke (Hagen -) Schwerte - Warburg
* (Obere Ruhrtalbahn)
**/
$newPath = new Path();
$newPath->setStartStation(87);
$newPath->setEndStation(89);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(55);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(false);
Path::addObject(102, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(89);
$newPath->setEndStation(91);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(35);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(false);
Path::addObject(103, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(91);
$newPath->setEndStation(92);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(34);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(false);
Path::addObject(104, $newPath, Path::GROUP_SMALL);

$newPath = new Path();
$newPath->setStartStation(92);
$newPath->setEndStation(88);
$newPath->setTwistingFactor(0.4);
$newPath->setLength(25);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(false);
Path::addObject(105, $newPath, Path::GROUP_SMALL);

/**
* Bahnstrecke Warburg - Kassel
**/
$newPath = new Path();
$newPath->setStartStation(88);
$newPath->setEndStation(26);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(52);
$newPath->setMaxSpeed(140);
$newPath->setElectrified(true);
Path::addObject(106, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Hamm - Warburg
**/
$newPath = new Path();
$newPath->setStartStation(84);
$newPath->setEndStation(90);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(25);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(107, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(90);
$newPath->setEndStation(29);
$newPath->setTwistingFactor(0.25);
$newPath->setLength(52);
$newPath->setMaxSpeed(200);
$newPath->setElectrified(true);
Path::addObject(108, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(29);
$newPath->setEndStation(93);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(18);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(109, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(93);
$newPath->setEndStation(88);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(37);
$newPath->setMaxSpeed(120);
$newPath->setElectrified(true);
Path::addObject(110, $newPath, Path::GROUP_MAIN);

/**
* Bahnstrecke Gemünden - Bad Kissing
**/
$newPath = new Path();
$newPath->setStartStation(98);
$newPath->setEndStation(97);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(50);
$newPath->setMaxSpeed(80);
$newPath->setElectrified(false);
Path::addObject(112, $newPath, Path::GROUP_SMALL);

/**
* Bahnstrecke Schweinfurt - Ebenhausen - Bad Kissing
**/

$newPath = new Path();
$newPath->setStartStation(96);
$newPath->setEndStation(97);
$newPath->setTwistingFactor(0.45);
$newPath->setLength(23);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(false);
Path::addObject(113, $newPath, Path::GROUP_SMALL);

/**
* Bahnstrecke Bamberg - Würzburg
**/
$newPath = new Path();
$newPath->setStartStation(95);
$newPath->setEndStation(96);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(57);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(116, $newPath, Path::GROUP_MAIN);

$newPath = new Path();
$newPath->setStartStation(96);
$newPath->setEndStation(24);
$newPath->setTwistingFactor(0.35);
$newPath->setLength(38);
$newPath->setMaxSpeed(160);
$newPath->setElectrified(true);
Path::addObject(117, $newPath, Path::GROUP_MAIN);
?>