<?php
/**
*
* Bahnhofs-Daten, die in die Station-Klasse eingefügt werden.
* Datum: 6. November 2012
*
**/
use \Game\Station;

$newStation = new Station('Köln Hbf');
$newStation->setX(45);
$newStation->setY(135);
$newStation->setPlatformLength(490);
$newStation->setPlatforms(11);
Station::addObject(0, $newStation, Station::GROUP_BIG);

$newStation = new Station('Bonn Hbf');
$newStation->setX(95);
$newStation->setY(185);
$newStation->setPlatformLength(440);
$newStation->setPlatforms(5);
Station::addObject(1, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Remagen');
$newStation->setX(105);
$newStation->setY(215);
$newStation->setPlatformLength(405);
$newStation->setPlatforms(5);
Station::addObject(2, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Andernach');
$newStation->setX(125);
$newStation->setY(235);
$newStation->setPlatformLength(410);
$newStation->setPlatforms(4);
Station::addObject(3, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Koblenz Hbf');
$newStation->setX(155);
$newStation->setY(255);
$newStation->setPlatformLength(500);
$newStation->setPlatforms(12);
Station::addObject(4, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Bingen (Rhein) Hbf');
$newStation->setX(175);
$newStation->setY(303);
$newStation->setPlatformLength(415);
$newStation->setPlatforms(6);
Station::addObject(5, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Mainz Hbf');
$newStation->setX(225);
$newStation->setY(305);
$newStation->setPlatformLength(705);
$newStation->setPlatforms(9);
Station::addObject(6, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Rüsselsheim');
$newStation->setX(250);
$newStation->setY(310);
$newStation->setPlatformLength(300);
$newStation->setPlatforms(3);
Station::addObject(7, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Frankfurt (Main) Flughafen');
$newStation->setX(270);
$newStation->setY(300);
$newStation->setPlatformLength(430);
$newStation->setPlatforms(7);
Station::addObject(8, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Frankfurt (Main) Hbf');
$newStation->setX(290);
$newStation->setY(290);
$newStation->setPlatformLength(420);
$newStation->setPlatforms(29);
Station::addObject(9, $newStation, Station::GROUP_BIG);

$newStation = new Station('Limburg Süd');
$newStation->setX(215);
$newStation->setY(245);
$newStation->setPlatformLength(405);
$newStation->setPlatforms(2);
Station::addObject(10, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Montabaur');
$newStation->setX(200);
$newStation->setY(225);
$newStation->setPlatformLength(405);
$newStation->setPlatforms(3);
Station::addObject(11, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Siegburg/Bonn');
$newStation->setX(155);
$newStation->setY(175);
$newStation->setPlatformLength(420);
$newStation->setPlatforms(4);
Station::addObject(12, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Köln Messe/Deutz');
$newStation->setX(55);
$newStation->setY(130);
$newStation->setPlatformLength(410);
$newStation->setPlatforms(10);
Station::addObject(13, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Düsseldorf Hbf');
$newStation->setX(35);
$newStation->setY(85);
$newStation->setPlatformLength(460);
$newStation->setPlatforms(16);
Station::addObject(14, $newStation, Station::GROUP_BIG);

$newStation = new Station('Mannheim Hbf');
$newStation->setX(270);
$newStation->setY(375);
$newStation->setPlatformLength(470);
$newStation->setPlatforms(9);
Station::addObject(15, $newStation, Station::GROUP_BIG);

$newStation = new Station('Groß Gerau-Dornberg');
$newStation->setX(275);
$newStation->setY(315);
$newStation->setPlatformLength(220);
$newStation->setPlatforms(5);
Station::addObject(16, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Biblis');
$newStation->setX(270);
$newStation->setY(355);
$newStation->setPlatformLength(250);
$newStation->setPlatforms(5);
Station::addObject(17, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Frankenthal Hbf');
$newStation->setX(255);
$newStation->setY(365);
$newStation->setPlatformLength(322);
$newStation->setPlatforms(3);
Station::addObject(18, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Worms Hbf');
$newStation->setX(250);
$newStation->setY(355);
$newStation->setPlatformLength(450);
$newStation->setPlatforms(9);
Station::addObject(19, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Freinsheim');
$newStation->setX(235);
$newStation->setY(370);
$newStation->setPlatformLength(240);
$newStation->setPlatforms(4);
Station::addObject(20, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Grünstadt');
$newStation->setX(230);
$newStation->setY(360);
$newStation->setPlatformLength(210);
$newStation->setPlatforms(4);
Station::addObject(21, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Saarbrücken Hbf');
$newStation->setX(35);
$newStation->setY(405);
$newStation->setPlatformLength(405);
$newStation->setPlatforms(10);
Station::addObject(22, $newStation, Station::GROUP_BIG);

$newStation = new Station('Trier Hbf');
$newStation->setX(15);
$newStation->setY(335);
$newStation->setPlatformLength(440);
$newStation->setPlatforms(5);
Station::addObject(23, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Würzburg Hbf');
$newStation->setX(475);
$newStation->setY(335);
$newStation->setPlatformLength(445);
$newStation->setPlatforms(10);
Station::addObject(24, $newStation, Station::GROUP_BIG);

$newStation = new Station('Fulda');
$newStation->setX(445);
$newStation->setY(205);
$newStation->setPlatformLength(450);
$newStation->setPlatforms(10);
Station::addObject(25, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Kassel-Willhelmshöhe');
$newStation->setX(445);
$newStation->setY(55);
$newStation->setPlatformLength(450);
$newStation->setPlatforms(8);
Station::addObject(26, $newStation, Station::GROUP_BIG);

$newStation = new Station('Dortmund Hbf');
$newStation->setX(155);
$newStation->setY(30);
$newStation->setPlatformLength(490);
$newStation->setPlatforms(16);
Station::addObject(27, $newStation, Station::GROUP_BIG);

$newStation = new Station('Nürnberg Hbf');
$newStation->setX(625);
$newStation->setY(385);
$newStation->setPlatformLength(410);
$newStation->setPlatforms(23);
Station::addObject(28, $newStation, Station::GROUP_BIG);

$newStation = new Station('Paderborn Hbf');
$newStation->setX(315);
$newStation->setY(5);
$newStation->setPlatformLength(330);
$newStation->setPlatforms(5);
Station::addObject(29, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Gießen Hbf');
$newStation->setX(290);
$newStation->setY(220);
$newStation->setPlatformLength(425);
$newStation->setPlatforms(11);
Station::addObject(30, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Bad Kreuznach');
$newStation->setX(175);
$newStation->setY(325);
$newStation->setPlatformLength(210);
$newStation->setPlatforms(5);
Station::addObject(31, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Bad Münster am Stein');
$newStation->setX(175);
$newStation->setY(340);
$newStation->setPlatformLength(300);
$newStation->setPlatforms(4);
Station::addObject(32, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Idar-Oberstein');
$newStation->setX(115);
$newStation->setY(350);
$newStation->setPlatformLength(230);
$newStation->setPlatforms(3);
Station::addObject(33, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Türkismühle');
$newStation->setX(95);
$newStation->setY(360);
$newStation->setPlatformLength(255);
$newStation->setPlatforms(3);
Station::addObject(34, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Neunkirchen (Saar) Hbf');
$newStation->setX(95);
$newStation->setY(385);
$newStation->setPlatformLength(300);
$newStation->setPlatforms(6);
Station::addObject(35, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Schifferstadt');
$newStation->setX(255);
$newStation->setY(385);
$newStation->setPlatformLength(490);
$newStation->setPlatforms(3);
Station::addObject(36, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Neustadt (Weinstr) Hbf');
$newStation->setX(215);
$newStation->setY(395);
$newStation->setPlatformLength(400);
$newStation->setPlatforms(6);
Station::addObject(37, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Kaiserslautern Hbf');
$newStation->setX(180);
$newStation->setY(380);
$newStation->setPlatformLength(540);
$newStation->setPlatforms(13);
Station::addObject(38, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Homburg (Saar) Hbf');
$newStation->setX(115);
$newStation->setY(390);
$newStation->setPlatformLength(400);
$newStation->setPlatforms(7);
Station::addObject(39, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Rohrbach (Saar)');
$newStation->setX(95);
$newStation->setY(400);
$newStation->setPlatformLength(180);
$newStation->setPlatforms(3);
Station::addObject(40, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Bad Dürkheim');
$newStation->setX(225);
$newStation->setY(385);
$newStation->setPlatformLength(320);
$newStation->setPlatforms(3);
Station::addObject(41, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Saarlouis Hbf');
$newStation->setX(5);
$newStation->setY(395);
$newStation->setPlatformLength(315);
$newStation->setPlatforms(3);
Station::addObject(42, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Merzig (Saar)');
$newStation->setX(0);
$newStation->setY(380);
$newStation->setPlatformLength(320);
$newStation->setPlatforms(3);
Station::addObject(43, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Wiltingen (Saar)');
$newStation->setX(0);
$newStation->setY(355);
$newStation->setPlatformLength(245);
$newStation->setPlatforms(2);
Station::addObject(44, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Wittlich Hbf');
$newStation->setX(55);
$newStation->setY(290);
$newStation->setPlatformLength(280);
$newStation->setPlatforms(5);
Station::addObject(45, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Bullay DB');
$newStation->setX(95);
$newStation->setY(280);
$newStation->setPlatformLength(290);
$newStation->setPlatforms(4);
Station::addObject(46, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Bitburg-Erdorf');
$newStation->setX(0);
$newStation->setY(300);
$newStation->setPlatformLength(210);
$newStation->setPlatforms(4);
Station::addObject(47, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Gerolstein');
$newStation->setX(25);
$newStation->setY(255);
$newStation->setPlatformLength(285);
$newStation->setPlatforms(5);
Station::addObject(48, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Euskirchen');
$newStation->setX(30);
$newStation->setY(215);
$newStation->setPlatformLength(165);
$newStation->setPlatforms(5);
Station::addObject(49, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Erftstadt');
$newStation->setX(25);
$newStation->setY(165);
$newStation->setPlatformLength(285);
$newStation->setPlatforms(3);
Station::addObject(50, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Wetzlar');
$newStation->setX(270);
$newStation->setY(225);
$newStation->setPlatformLength(310);
$newStation->setPlatforms(5);
Station::addObject(51, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Weilburg');
$newStation->setX(245);
$newStation->setY(240);
$newStation->setPlatformLength(190);
$newStation->setPlatforms(2);
Station::addObject(52, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Limburg (Lahn)');
$newStation->setX(205);
$newStation->setY(240);
$newStation->setPlatformLength(250);
$newStation->setPlatforms(6);
Station::addObject(53, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Nassau (Lahn)');
$newStation->setX(175);
$newStation->setY(260);
$newStation->setPlatformLength(240);
$newStation->setPlatforms(3);
Station::addObject(54, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Siegen');
$newStation->setX(235);
$newStation->setY(175);
$newStation->setPlatformLength(355);
$newStation->setPlatforms(6);
Station::addObject(55, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Herborn (Dillkr)');
$newStation->setX(260);
$newStation->setY(210);
$newStation->setPlatformLength(265);
$newStation->setPlatforms(3);
Station::addObject(56, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Haiger');
$newStation->setX(245);
$newStation->setY(190);
$newStation->setPlatformLength(275);
$newStation->setPlatforms(3);
Station::addObject(57, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Friedberg (Hess)');
$newStation->setX(295);
$newStation->setY(255);
$newStation->setPlatformLength(330);
$newStation->setPlatforms(10);
Station::addObject(58, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Niederweimar');
$newStation->setX(305);
$newStation->setY(185);
$newStation->setPlatformLength(180);
$newStation->setPlatforms(2);
Station::addObject(59, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Marburg (Lahn)');
$newStation->setX(310);
$newStation->setY(170);
$newStation->setPlatformLength(425);
$newStation->setPlatforms(5);
Station::addObject(60, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Bad Nauheim');
$newStation->setX(290);
$newStation->setY(245);
$newStation->setPlatformLength(258);
$newStation->setPlatforms(3);
Station::addObject(61, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Bad Vilbel');
$newStation->setX(295);
$newStation->setY(277);
$newStation->setPlatformLength(280);
$newStation->setPlatforms(5);
Station::addObject(62, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Kirchhain (Bz Kassel)');
$newStation->setX(330);
$newStation->setY(145);
$newStation->setPlatformLength(305);
$newStation->setPlatforms(3);
Station::addObject(63, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Treysa');
$newStation->setX(355);
$newStation->setY(115);
$newStation->setPlatformLength(420);
$newStation->setPlatforms(5);
Station::addObject(64, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Wabern (Bz Kassel)');
$newStation->setX(410);
$newStation->setY(90);
$newStation->setPlatformLength(400);
$newStation->setPlatforms(5);
Station::addObject(65, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Baunatal-Guntershausen');
$newStation->setX(440);
$newStation->setY(70);
$newStation->setPlatformLength(290);
$newStation->setPlatforms(4);
Station::addObject(66, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Offenbach (Main) Hbf');
$newStation->setX(303);
$newStation->setY(293);
$newStation->setPlatformLength(410);
$newStation->setPlatforms(6);
Station::addObject(67, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Hanau Hbf');
$newStation->setX(315);
$newStation->setY(285);
$newStation->setPlatformLength(410);
$newStation->setPlatforms(11);
Station::addObject(68, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Gelnhausen');
$newStation->setX(350);
$newStation->setY(275);
$newStation->setPlatformLength(340);
$newStation->setPlatforms(4);
Station::addObject(69, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Wächtersbach');
$newStation->setX(365);
$newStation->setY(265);
$newStation->setPlatformLength(430);
$newStation->setPlatforms(3);
Station::addObject(70, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Schlüchtern');
$newStation->setX(410);
$newStation->setY(240);
$newStation->setPlatformLength(335);
$newStation->setPlatforms(4);
Station::addObject(71, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Flieden');
$newStation->setX(435);
$newStation->setY(225);
$newStation->setPlatformLength(340);
$newStation->setPlatforms(4);
Station::addObject(72, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Betzdorf (Sieg)');
$newStation->setX(215);
$newStation->setY(185);
$newStation->setPlatformLength(270);
$newStation->setPlatforms(5);
Station::addObject(73, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Eitorf');
$newStation->setX(185);
$newStation->setY(185);
$newStation->setPlatformLength(210);
$newStation->setPlatforms(2);
Station::addObject(74, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Bbf Rohrbach');
$newStation->setX(455);
$newStation->setY(305);
$newStation->setPlatformLength(0);
$newStation->setPlatforms(0);
Station::addObject(75, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Aschaffenburg Hbf');
$newStation->setX(350);
$newStation->setY(305);
$newStation->setPlatformLength(450);
$newStation->setPlatforms(8);
Station::addObject(76, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Lohr Bahnhof');
$newStation->setX(415);
$newStation->setY(300);
$newStation->setPlatformLength(355);
$newStation->setPlatforms(3);
Station::addObject(77, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Fürth (Bay) Hbf');
$newStation->setX(617);
$newStation->setY(378);
$newStation->setPlatformLength(410);
$newStation->setPlatforms(8);
Station::addObject(78, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Neustadt (Aisch) Bahnhof');
$newStation->setX(575);
$newStation->setY(360);
$newStation->setPlatformLength(430);
$newStation->setPlatforms(6);
Station::addObject(79, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Iphofen');
$newStation->setX(505);
$newStation->setY(345);
$newStation->setPlatformLength(180);
$newStation->setPlatforms(2);
Station::addObject(80, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Duisburg Hbf');
$newStation->setX(40);
$newStation->setY(55);
$newStation->setPlatformLength(500);
$newStation->setPlatforms(12);
Station::addObject(81, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Essen Hbf');
$newStation->setX(75);
$newStation->setY(50);
$newStation->setPlatformLength(480);
$newStation->setPlatforms(13);
Station::addObject(82, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Bochum Hbf');
$newStation->setX(110);
$newStation->setY(40);
$newStation->setPlatformLength(435);
$newStation->setPlatforms(8);
Station::addObject(83, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Hamm (Westf)');
$newStation->setX(215);
$newStation->setY(15);
$newStation->setPlatformLength(420);
$newStation->setPlatforms(12);
Station::addObject(84, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Solingen Hbf');
$newStation->setX(65);
$newStation->setY(95);
$newStation->setPlatformLength(225);
$newStation->setPlatforms(5);
Station::addObject(85, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Wuppertal Hbf');
$newStation->setX(85);
$newStation->setY(75);
$newStation->setPlatformLength(420);
$newStation->setPlatforms(5);
Station::addObject(86, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Hagen Hbf');
$newStation->setX(150);
$newStation->setY(60);
$newStation->setPlatformLength(260);
$newStation->setPlatforms(16);
Station::addObject(87, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Warburg (Westf)');
$newStation->setX(395);
$newStation->setY(35);
$newStation->setPlatformLength(360);
$newStation->setPlatforms(4);
Station::addObject(88, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Arnsberg (Westf)');
$newStation->setX(245);
$newStation->setY(40);
$newStation->setPlatformLength(340);
$newStation->setPlatforms(3);
Station::addObject(89, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Soest');
$newStation->setX(255);
$newStation->setY(25);
$newStation->setPlatformLength(275);
$newStation->setPlatforms(3);
Station::addObject(90, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Olsberg');
$newStation->setX(285);
$newStation->setY(55);
$newStation->setPlatformLength(250);
$newStation->setPlatforms(3);
Station::addObject(91, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Marsberg');
$newStation->setX(335);
$newStation->setY(35);
$newStation->setPlatformLength(250);
$newStation->setPlatforms(2);
Station::addObject(92, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Altenbeken');
$newStation->setX(355);
$newStation->setY(0);
$newStation->setPlatformLength(495);
$newStation->setPlatforms(11);
Station::addObject(93, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Erlangen');
$newStation->setX(620);
$newStation->setY(355);
$newStation->setPlatformLength(420);
$newStation->setPlatforms(4);
Station::addObject(94, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Bamberg');
$newStation->setX(610);
$newStation->setY(310);
$newStation->setPlatformLength(370);
$newStation->setPlatforms(7);
Station::addObject(95, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Schweinfurt Hbf');
$newStation->setX(490);
$newStation->setY(295);
$newStation->setPlatformLength(470);
$newStation->setPlatforms(8);
Station::addObject(96, $newStation, Station::GROUP_MIDDLE);

$newStation = new Station('Bad Kissingen');
$newStation->setX(480);
$newStation->setY(285);
$newStation->setPlatformLength(230);
$newStation->setPlatforms(3);
Station::addObject(97, $newStation, Station::GROUP_SMALL);

$newStation = new Station('Gemünden (Main)');
$newStation->setX(460);
$newStation->setY(295);
$newStation->setPlatformLength(415);
$newStation->setPlatforms(8);
Station::addObject(98, $newStation, Station::GROUP_SMALL)
?>