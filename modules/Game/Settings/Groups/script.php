<?php
/**
*
* Oberfläche zur Änderung des Passwords und der E-Mail-Adresse
* Datum: 5. November 2012
*
**/
script {
	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('editGroup', -1);
		
		try {
			if(isset($options['makeAction'])) {
				if($options['makeAction'] == 'edit' && isset($options['groupID'])) $this->mi()->addVarCache('editGroup', $options['groupID']);
				else if($options['makeAction'] == 'saveEdit' && isset($options['groupID'])) $this->edit($options['groupID']);
				else if($options['makeAction'] == 'delete' && isset($options['groupID'])) $this->delete($options['groupID']);
				else if($options['makeAction'] == 'new') $this->add();
			}
		} catch(\HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
		
		$this->mi()->addVarCache('trainUnitGroups', $this->ui()->listTrainUnitGroups());
	}
	
	/**
	* Bearbeitet eine Gruppe
	*
	* @param int $groupID - Gruppen-ID
	**/
	private function edit($groupID) {
		$currentGroup = self::getTrainUnitGroupForID($groupID);
			
		$groupName = isset($_POST['groupName']) ? $_POST['groupName'] : '';
		$currentGroup->setName($groupName);
		
		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', 'Die Gruppe wurde erfolgreich umgenannt.');
	}
	
	/**
	* Löscht eine Gruppe
	*
	* @param int $groupID - Gruppen-ID
	**/
	private function delete($groupID) {
		$trainUnitGroups = $this->ui()->listTrainUnitGroups();
		$currentGroup = $this->getTrainUnitGroupForID($groupID);
		
		$mainGroup = $trainUnitGroups[0];
		$currentGroup = $trainUnitGroups[$groupID];
		
		foreach($currentGroup->listIDs() as $currentID) $mainGroup->addToEnd($currentID);
		
		$this->ui()->removeTrainUnitGroup($groupID);
		
		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', 'Die Gruppe wurde erfolgreich gelöscht. Noch vorhande Zugeinheiten wurden in die Hauptgruppe verschoben.');
	}
	
	/**
	* Erstellt eine neue Gruppe
	**/
	private function add() {
		$groupName = isset($_POST['groupName']) ? $_POST['groupName'] : '';
		$this->ui()->addTrainUnitGroup(new TrainUnitGroup($groupName));
		
		$this->mi()->addVarCache('showSuccess', true);
		$this->mi()->addVarCache('successString', 'Die Gruppe wurde erfolgreich erstellt.');
	}
	
	/**
	* Gibt das Gruppen.Objekt zur Gruppen-ID zurück.
	*
	* @param int $groupID - Gruppen-ID
	* @return TrainUnitGroup - Gruppen-Objekt
	**/
	private function getTrainUnitGroupForID($groupID) {
		if ($groupID == 0)
			throw new \HumanException('Du kannst die Hauptgruppe nicht bearbeiten!', -1);
		
		$trainUnitGroups = $this->ui()->listTrainUnitGroups();
		if(!isset($trainUnitGroups[$groupID]))
			throw new \HumanException('Ungültige Fahrzeuggruppe ausgewählt. Bitte versuch’ es erneut!', -2);
		
		return $trainUnitGroups[$groupID];
	}
}
?>