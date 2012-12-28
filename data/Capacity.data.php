<?php
/**
*
* Zug-Daten, die in die Train-Klasse eingefügt werden.
* Datum: 24. Oktober 2012
*
**/
use \Game\Capacity;

$newCapacity = new Capacity("Fahrgäste");
$newCapacity->setUnit('');
$newCapacity->setUnitMass(0.07);
$newCapacity->setIcon('group.png');
Capacity::addObject(0, $newCapacity);

$newCapacity = new Capacity("Holz");
$newCapacity->setUnit('t');
$newCapacity->setUnitMass(1);
$newCapacity->setIcon('box.png');
Capacity::addObject(1, $newCapacity);

$newCapacity = new Capacity("Öl");
$newCapacity->setUnit('l');
$newCapacity->setUnitMass(0.0008);
$newCapacity->setIcon('database.png');
Capacity::addObject(2, $newCapacity);

$newCapacity = new Capacity("Pillen");
$newCapacity->setUnit('t');
$newCapacity->setUnitMass(1);
$newCapacity->setIcon('pil.png');
Capacity::addObject(3, $newCapacity);

$newCapacity = new Capacity("Autos");
$newCapacity->setUnit('');
$newCapacity->setUnitMass(1.7);
$newCapacity->setIcon('car.png');
Capacity::addObject(4, $newCapacity);
?>