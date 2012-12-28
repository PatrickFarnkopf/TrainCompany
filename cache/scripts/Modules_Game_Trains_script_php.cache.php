<?php
/**
*
* Die Klasse der Zugübersicht
* Datum: 24. Oktober 2012
*
**/
namespace Script; class Modules_Game_Trains_script_php extends \Core\Module\Extender  {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Fahrzeuge');
		
		$this->mi()->addVarCache('maxTrainLength', \Game\Train\Unit::MAX_LENGTH);
		
		$trainUnitGroups = $this->ui()->listTrainUnitGroups();
		$this->mi()->addVarCache('trainUnitGroups', $trainUnitGroups);
		$this->mi()->addVarCache('currentUnitGroupID', isset($options['groupID']) && isset($trainUnitGroups[$options['groupID']]) ? $options['groupID'] : 0);
		
		try {
			if(isset($options['makeAction']) && $options['makeAction']) {
				if(isset($_POST['connect'])) 
					$this->connect();
				else if(isset($_POST['sell']))
					$this->sell();
				else if(isset($_POST['group']) && isset($_POST['groupID'])) 
					$this->regrouping();
			}
			if(isset($options['splitUp']) && $options['splitUp']) $this->splitUp();
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
		

		$this->mi()->addVarCache('trainUnits', $this->ui()->listTrainUnits($this->mi()->getVarCache('currentUnitGroupID')));
	}
	
	/**
	* Gibt zurück, welche Zugeinheiten ausgewählt wurden
	*
	* @param bool $canLocked - Dürfen gesperrte Zugeinheiten verwendet werden [optional]
	* @return array
	**/
	private function getSelectedTrainUnits($canLocked = false) {
		$userTrainUnits = $this->ui()->listTrainUnits($this->mi()->getVarCache('currentUnitGroupID'));
		$trainUnitIDs = isset($_POST['trainUnits']) ? $_POST['trainUnits'] : array();
		$trainUnits = array();
		
		if(count($trainUnitIDs) == 0)
			throw new \HumanException('Keine Zugeinheiten ausgewählt.', -1);
		
		foreach($trainUnitIDs as $currentTrainUnitID=>$checked) {
			if(!isset($userTrainUnits[$currentTrainUnitID]))
				throw new \HumanException('Ungültige Zugeinheiten ausgewählt. Bitte versuch’ es erneut!', -2);
			else if($userTrainUnits[$currentTrainUnitID]->isLocked() && !$canLocked)
				throw new \HumanException('Mindestens eine der ausgewählten Zugeinheiten ist gesperrt.', -3);
			
			$trainUnits[] = $userTrainUnits[$currentTrainUnitID];
		}
		if(count($trainUnits) == 0) return false;
		
		return array('trainUnitIDs'=>$trainUnitIDs,'trainUnits'=>$trainUnits);
	}
	
	/**
	* Verkauft Zugeinheiten
	**/
	private function sell() {
		$selectedTrainUnits = $this->getSelectedTrainUnits();
		$trainUnitIDs = $selectedTrainUnits['trainUnitIDs'];
		$trainUnits = $selectedTrainUnits['trainUnits'];
		
		$newPlops = 0;
		foreach($trainUnits as $currentTrainUnit) $newPlops += $currentTrainUnit->getSellPrice();
		
		foreach($trainUnitIDs as $currentTrainUnitID=>$checked) {
			$this->ui()->listTrainUnitGroups()[$this->mi()->getVarCache('currentUnitGroupID')]->del($currentTrainUnitID);
			$this->ui()->removeTrainUnit($currentTrainUnitID);
		}
		
		$this->ui()->addPlops($newPlops);
		
		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', 'Die Zugeinheiten wurden erfolgreich verkauft. Du hast dadurch '.\Core\Format::number($newPlops).' Plops wieder bekommen.');
	}
	
	/**
	* Fügt mehrere Zugeinheiten zusammen
	**/
	private function connect() {
		$selectedTrainUnits = $this->getSelectedTrainUnits();
		$trainUnitIDs = $selectedTrainUnits['trainUnitIDs'];
		$trainUnits = $selectedTrainUnits['trainUnits'];
		
		$newTrainUnit = \Game\Train\Unit::fuseTrainUnits($trainUnits);
		
		foreach($trainUnitIDs as $currentTrainUnitID=>$checked) {
			$this->ui()->listTrainUnitGroups()[$this->mi()->getVarCache('currentUnitGroupID')]->del($currentTrainUnitID);
			$this->ui()->removeTrainUnit($currentTrainUnitID);
		}
		
		$id = $this->ui()->addTrainUnit($newTrainUnit);
		$this->ui()->listTrainUnitGroups()[$this->mi()->getVarCache('currentUnitGroupID')]->addToEnd($id);
		
		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', 'Die Zugeinheiten wurden erfolgreich zu einer gemeinsamen Zugeinheit verbunden.');
	}
	
	/**
	* Trennt eine Zugeinheit
	**/
	private function splitUp() {
		$options = $this->mi()->getVarCache('options');
		if(!isset($options['trainUnit']) || !isset($options['element'])) return;
		
		$userTrainUnits = $this->ui()->listTrainUnits($this->mi()->getVarCache('currentUnitGroupID'));
		$trainUnitID = $options['trainUnit'];
		$element = $options['element'];
		
		if(!isset($userTrainUnits[$trainUnitID]))
			throw new \HumanException('Ungültige Zugeinheit ausgewählt.', -1);
		else if($userTrainUnits[$trainUnitID]->isLocked())
			throw new \HumanException('Die ausgewählte Zugeinheit ist gesperrt.', -2);
		
		$newTrainUnit = $userTrainUnits[$trainUnitID]->splitUpUnitBefore($element);
		if(count($newTrainUnit->listTrains())) {
			$id = $this->ui()->addTrainUnit($newTrainUnit);
			$this->ui()->listTrainUnitGroups()[$this->mi()->getVarCache('currentUnitGroupID')]->addAfter($id,$trainUnitID);
			
			$this->mi()->addVarCache('showSuccess', true);
			$this->mi()->addVarCache('successString', 'Die Zugeinheiten wurden erfolgreich geteilt.');
		}
	}
	
	/**
	* Gruppiert Zugeinheit um
	**/
	private function regrouping() {
		$selectedTrainUnits = $this->getSelectedTrainUnits(true);
		$trainUnitIDs = $selectedTrainUnits['trainUnitIDs'];
		
		$selectedTrainUnitGroup = $_POST['groupID'];
		$trainUnitGroups = $this->mi()->getVarCache('trainUnitGroups');
		if(!isset($trainUnitGroups[$selectedTrainUnitGroup]))
			throw new \HumanException('Die ausgewählte Fahrzeuggruppe existiert nicht. Bitte versuch’ es erneut!', -1);

		foreach($trainUnitIDs as $currentTrainUnitID=>$checked) {
			$this->ui()->listTrainUnitGroups()[$selectedTrainUnitGroup]->addToEnd($currentTrainUnitID);
			$this->ui()->listTrainUnitGroups()[$this->mi()->getVarCache('currentUnitGroupID')]->del($currentTrainUnitID);
		}
		
		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', 'Die Zugeinheiten wurden erfolgreich umgruppiert.');
	}
}
?>