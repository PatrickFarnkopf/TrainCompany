<?php
/**
*
* Die Klasse für das Module, das das Kaufen neuer Züge ermöglicht.
* Datum: 24. Oktober 2012
*
**/
namespace Script; class Modules_Game_Trains_Buy_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Neue Fahrzeuge');
		$this->mi()->addVarCache('trainType', isset($options['trainType']) ? $options['trainType'] : \Game\Train::GROUP_UNIT);
		
		$trainTypes = array(\Game\Train::GROUP_UNIT=>'Triebzüge',
							\Game\Train::GROUP_LOCO=>'Lokomotiven',
							\Game\Train::GROUP_WAGON=>'Wagons');
		$this->mi()->addVarCache('trainTypes', $trainTypes);
			
		$this->getTrainList($this->mi()->getVarCache('trainType'));
		
		try {
			if(isset($options['buyTrains']) && $options['buyTrains']) $this->buyTrains();
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		} 
	}
	
	/**
	* Lädt die Züge aus den Daten uns speichert sie im VarCach.
	*
	* @param int $type - Zuggattung?
	**/
	private function getTrainList($type) {
		return $this->mi()->addVarCache('trainList', \Game\Train::getList($type));
	}
	
	/**
	* Führt einen Zugkauf durch.
	**/
	private function buyTrains() {
		$totalCost = 0;
		$trains = isset($_POST['trains']) && is_array($_POST['trains']) ? $_POST['trains'] : array();
		$newTrainUnits = array();
		
		foreach($trains as $trainID => $trainCount) {
			if(!is_numeric($trainCount)) $trainCount = 0; 
			if(!\Game\Train::existObjectForID($trainID))
				throw new \HumanException('Du versuchst einen dem System unbekannten Zug zu kaufen. Das geht leider nicht. :(', -1);
				
			$trainObject = clone \Game\Train::getObjectForID($trainID);
			$trainObject->setBoughtTime();
			$totalCost += $trainObject->getCost()*$trainCount;
			
			for($i=0;$i<$trainCount;$i++) {
				$newTrainUnit = new \Game\Train\Unit();
				$newTrainUnit->addTrains(array(clone $trainObject));
				
				$newTrainUnits[] = $newTrainUnit;
			}
		}
		
		if($totalCost > $this->ui()->getPlops())
			throw new \HumanException('Du hast nicht genügend Geld, um dir diese Fahrzeuge zu kaufen.', -2);
		
		$this->ui()->subPlops($totalCost);		
		foreach($newTrainUnits as $trainUnit) {
			$id = $this->ui()->addTrainUnit($trainUnit);
			$this->ui()->listTrainUnitGroups()[0]->addToEnd($id);
		}
		
		$newCount = count($newTrainUnits);
		if($newCount == 0)
			throw new \HumanException('Du hast keine Fahrzeuge zum Kaufen ausgewählt.', -3);
		
		$this->mi()->addVarCache('showSuccess', true);
		if($newCount > 1) $this->mi()->addVarCache('successString', 'Die '.Format::number($newCount).' Fahrzeuge wurden erfolgreich gekauft.');
		else $this->mi()->addVarCache('successString', 'Das Fahrzeug wurde erfolgreich gekauft.');
	}
}