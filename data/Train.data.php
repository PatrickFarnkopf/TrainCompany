<?php
/**
*
* Zug-Daten, die in die Train-Klasse eingefügt werden.
* Datum: 24. Oktober 2012
*
**/
use \Game\Train;

$newTrain = new Train('Siemens Velaro D');
$newTrain->setCapacity(array(0 => 460));
$newTrain->setSpeed(330);
$newTrain->setWeight(454);
$newTrain->setForce(300);
$newTrain->setLength(200);
$newTrain->setDrive(Train::ELECTRO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(5000000);
$newTrain->setMaxConnectedUnits(2);
Train::addObject(0, $newTrain, Train::GROUP_UNIT);

$newTrain = new Train('Stadler DoSto');
$newTrain->setCapacity(array(0 => 535));
$newTrain->setSpeed(160);
$newTrain->setWeight(298);
$newTrain->setForce(400);
$newTrain->setLength(150);
$newTrain->setDrive(Train::ELECTRO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(850000);
$newTrain->setMaxConnectedUnits(4);
Train::addObject(1, $newTrain, Train::GROUP_UNIT);

$newTrain = new Train('BR 612');
$newTrain->setCapacity(array(0 => 146));
$newTrain->setSpeed(160);
$newTrain->setWeight(116);
$newTrain->setForce(100);
$newTrain->setLength(51);
$newTrain->setDrive(Train::DIESEL_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(450000);
$newTrain->setMaxConnectedUnits(4);
Train::addObject(2, $newTrain, Train::GROUP_UNIT);

$newTrain = new Train('BR 101');
$newTrain->setCapacity(array());
$newTrain->setSpeed(220);
$newTrain->setWeight(84);
$newTrain->setForce(300);
$newTrain->setLength(19);
$newTrain->setDrive(Train::ELECTRO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(350000);
$newTrain->setMaxConnectedUnits(0);
Train::addObject(3, $newTrain, Train::GROUP_LOCO);

$newTrain = new Train('IC-Wagen (bpmz)'); // Bpmz 291.0
$newTrain->setCapacity(array(0 => 80));
$newTrain->setSpeed(200);
$newTrain->setWeight(42);
$newTrain->setForce(0);
$newTrain->setLength(26);
$newTrain->setDrive(Train::NO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(180000);
$newTrain->setMaxConnectedUnits(0);
Train::addObject(4, $newTrain, Train::GROUP_WAGON);

$newTrain = new Train('BR 218');
$newTrain->setCapacity(array());
$newTrain->setSpeed(160);
$newTrain->setWeight(80);
$newTrain->setForce(235); // Eigentliche 235
$newTrain->setLength(16);
$newTrain->setDrive(Train::DIESEL_DRIVE);
$newTrain->setReliability(0.9);
$newTrain->setCost(200000);
$newTrain->setMaxConnectedUnits(0);
Train::addObject(5, $newTrain, Train::GROUP_LOCO);

$newTrain = new Train('BR 146.2'); 
$newTrain->setCapacity(array());
$newTrain->setSpeed(160);
$newTrain->setWeight(84);
$newTrain->setForce(300);
$newTrain->setLength(19);
$newTrain->setDrive(Train::ELECTRO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(300000);
Train::addObject(6, $newTrain, Train::GROUP_LOCO);

$newTrain = new Train('DoSto-Wagen'); // Bombardier TWINDEXX Mittelwagen
$newTrain->setCapacity(array(0=>121));
$newTrain->setSpeed(160);
$newTrain->setWeight(50);
$newTrain->setForce(0);
$newTrain->setLength(27);
$newTrain->setDrive(Train::NO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(180000);
$newTrain->setMaxConnectedUnits(0);
Train::addObject(7, $newTrain, Train::GROUP_WAGON);

$newTrain = new Train('Autotransportwagen');
$newTrain->setCapacity(array(4=>12));
$newTrain->setSpeed(120);
$newTrain->setWeight(45);
$newTrain->setForce(0);
$newTrain->setLength(31);
$newTrain->setDrive(Train::NO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(150000);
$newTrain->setMaxConnectedUnits(0);
Train::addObject(8, $newTrain, Train::GROUP_WAGON);

$newTrain = new Train('BR 425');
$newTrain->setCapacity(array(0=>206));
$newTrain->setSpeed(160);
$newTrain->setWeight(114);
$newTrain->setForce(140);
$newTrain->setLength(68);
$newTrain->setDrive(Train::ELECTRO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(500000);
$newTrain->setMaxConnectedUnits(3);
Train::addObject(9, $newTrain, Train::GROUP_UNIT);

$newTrain = new Train('Talent 2');
$newTrain->setCapacity(array(0=>221));
$newTrain->setSpeed(160);
$newTrain->setWeight(137);
$newTrain->setForce(190);
$newTrain->setLength(72);
$newTrain->setDrive(Train::ELECTRO_DRIVE);
$newTrain->setReliability(1.0);
$newTrain->setCost(600000);
$newTrain->setMaxConnectedUnits(4);
Train::addObject(10, $newTrain, Train::GROUP_UNIT);

$newTrain = new Train('n-Wagen');
$newTrain->setCapacity(array(0=>96));
$newTrain->setSpeed(140);
$newTrain->setWeight(40);
$newTrain->setForce(0);
$newTrain->setLength(26);
$newTrain->setDrive(Train::NO_DRIVE);
$newTrain->setReliability(0.9);
$newTrain->setCost(75000);
$newTrain->setMaxConnectedUnits(0);
Train::addObject(11, $newTrain, Train::GROUP_WAGON);

$newTrain = new Train('BR 143');
$newTrain->setCapacity(array());
$newTrain->setSpeed(120);
$newTrain->setWeight(83);
$newTrain->setForce(240);
$newTrain->setLength(17);
$newTrain->setDrive(Train::ELECTRO_DRIVE);
$newTrain->setReliability(0.9);
$newTrain->setCost(200000);
$newTrain->setMaxConnectedUnits(0);
Train::addObject(12, $newTrain, Train::GROUP_LOCO);
?>