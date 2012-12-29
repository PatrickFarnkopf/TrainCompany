<?php
/**
*
* Ausschreibungs-Modelle zum Erzeugen von Ausschreibungen
* Datum: 4. Dezember 2012
*
**/
use \Game\Task\Model, \Game\Task;

// +++ Regional-Express-Linien +++

$newModel = new Model('NRW-Express von %s nach %s');
$descriptions = array(	'Du musst den Regional-Express der Linie 1 von %s nach %s bringen. Dieser Zug ist sehr stark ausgelastet.',
						'Der RE1 von %s nach %s ist sehr stark ausgelastet. Plane genug Pufferzeit ein.',
						'Bringe den Regional-Express der Linie 1 pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(120000);
$newModel->setPlopDifferent(5);
$newModel->setStationIDs(array(0,13,14,81,82,83,27,84,90,29));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(0, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('Eifel-Mosel-Express von %s nach %s');
$descriptions = array(	'Bringe den RE12 von %s nach %s. Der Zug ist nur schwach ausgelastet.',
						'Der RE12 muss von %s nach %s gebracht werden. Die Strecke ist nicht stark ausgelastet.',
						'Bringe den Regional-Express der Linie 12 pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(80000);
$newModel->setPlopDifferent(5);
$newModel->setStationIDs(array(0,50,49,48,47,23));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(1, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('Sauerland-Express von %s nach %s');
$descriptions = array(	'Bringe den RE17 von %s nach %s. Der Zug ist nur mittelmäßig ausgelastet.',
						'Der RE17 muss von %s nach %s gebracht werden. Die Strecke ist nicht sehr stark ausgelastet.',
						'Bringe den Regional-Express der Linie 17 pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(110000);
$newModel->setPlopDifferent(5);
$newModel->setStationIDs(array(87,89,91,92,88,26));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(2, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('RE7 von %s nach %s');
$descriptions = array(	'Bringe den RE7 von %s nach %s. Der Zug ist nur mittelmäßig ausgelastet.',
						'Der RE7 muss von %s nach %s gebracht werden. Die Strecke ist nicht sehr stark ausgelastet.',
						'Bringe den Regional-Express der Linie 7 pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(90000);
$newModel->setPlopDifferent(5);
$newModel->setStationIDs(array(15,37,38,39,22));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(3, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('RE30 von %s nach %s');
$descriptions = array(	'Bringe den RE30 von %s nach %s. Der Zug ist stark ausgelastet.',
						'Der RE30 muss von %s nach %s gebracht werden. Die Strecke ist stark ausgelastet.',
						'Bringe den Regionl-Express der Linie 30 pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(130000);
$newModel->setPlopDifferent(5);
$newModel->setStationIDs(array(9,58,30,60,64,65,26));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(4, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('Nahe-Express von %s nach %s');
$descriptions = array(	'Bringe den RE3 von %s nach %s. Der Zug ist zeitweise stark ausgelastet.',
						'Der RE3 muss von %s nach %s gebracht werden. Die Strecke ist stark ausgelastet.',
						'Bringe den Regionl-Express der Linie 3 pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(140000);
$newModel->setPlopDifferent(5);
$newModel->setStationIDs(array(22,35,34,33,32,31,6,7,8,9));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(5, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('Regional-Express von %s nach %s');
$descriptions = array(	'Bringe den RE von %s nach %s. Die Strecke ist sehr kurvig.',
						'Der RE muss von %s nach %s gebracht werden. Die Strecke ist sehr kurvig.',
						'Bringe den Regionl-Express pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(90000);
$newModel->setPlopDifferent(5);
$newModel->setStationIDs(array(4,54,53,52,51,30));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(6, $newModel, Task::WITH_APPLICATION);

// +++ IC-Linien +++

$newModel = new Model('Intercity von %s nach %s');
$descriptions = array(	'Bringe den Intercity von %s nach %s, über die Rheinstrecke.',
						'Der IC muss von %s über die Rheinstrecke nach %s gebracht werden.',
						'Bringe den IC über die Rheinstrecke pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(160000);
$newModel->setPlopDifferent(8);
$newModel->setStationIDs(array(15,19,6,5,4,3,2,1,0));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(7, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('Intercity von %s nach %s');
$descriptions = array(	'Bringe den Intercity von %s nach %s, über die Rheinstrecke.',
						'Der IC muss von %s über die Rheinstrecke nach %s gebracht werden.',
						'Bringe den IC über die Rheinstrecke pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(150000);
$newModel->setPlopDifferent(8);
$newModel->setStationIDs(array(23,45,46,4,3,2,1,0));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(8, $newModel, Task::WITH_APPLICATION);

// +++ ICE-Linien +++

$newModel = new Model('ICE von %s nach %s');
$descriptions = array(	'Der ICE muss über die Schnellstrecke nach %2$s.',
						'Der ICE muss von %s über die SFS nach %s gebracht werden.',
						'Bringe den ICE über die SFS pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(250000);
$newModel->setPlopDifferent(8);
$newModel->setStationIDs(array(15,8,10,11,12,13,14,81,82,83,27));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(9, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('ICE von %s nach %s');
$descriptions = array(	'Der ICE muss über die Schnellstrecke nach %2$s.',
						'Der ICE muss von %s über die SFS nach %s gebracht werden.',
						'Bringe den ICE über die SFS pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(300000);
$newModel->setPlopDifferent(8);
$newModel->setStationIDs(array(28,24,76,68,9,8,10,11,12,13,86,87,84));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(10, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('ICE von %s nach %s');
$descriptions = array(	'Der ICE muss über die Schnellstrecke nach %2$s.',
						'Der ICE muss von %s über die SFS nach %s gebracht werden.',
						'Bringe den ICE über die SFS pünktlich von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(400000);
$newModel->setPlopDifferent(8);
$newModel->setStationIDs(array(9,8,10,11,12,13,86,87,84,90,29,93,88,26,25,24,28));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(11, $newModel, Task::WITH_APPLICATION);


$newModel = new Model('ICE von %s nach %s');
$descriptions = array(	'Der ICE muss nach %2$s gebracht. Er startet in %1$s.',
						'Der ICE muss von %s nach %s gebracht werden. Verwende die schnellste Strecke',
						'Bringe den ICE pünktlich und schnell von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(300000);
$newModel->setPlopDifferent(8);
$newModel->setStationIDs(array(15,9,68,25,26));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(12, $newModel, Task::WITH_APPLICATION);

$newModel = new Model('ICE von %s nach %s');
$descriptions = array(	'Der ICE muss nach %2$s gebracht. Er startet in %1$s.',
						'Der ICE muss von %s nach %s gebracht werden. Verwende die schnellste Strecke',
						'Bringe den ICE pünktlich und schnell von %s nach %s.');
$newModel->setDescriptions($descriptions);
$newModel->setPlops(280000);
$newModel->setPlopDifferent(8);
$newModel->setStationIDs(array(28,24,25,26));
$newModel->setNeededCapacity(array(0=>0));
$newModel->setNeededCapacityDifferent(0);
Model::addObject(13, $newModel, Task::WITH_APPLICATION);
?>