<?php
/**
*
* Auswählen der zu befahrenden Strecken.
* Datum: 28. November 2012
*
**/
script {
	private $mapInstance;

	private $taskID = false;
	private $task = false;
	private $taskApplication = false;

	private $pathUnits = array();
	private $selectedStations = array();

	public function __construct() {
		$options = $this->mi()->getVarCache('options');
		$this->mi()->addVarCache('siteTitle', 'Strecken auswählen');
		
		$this->mapInstance = new \Game\Map(\Game\Station::getList(),\Game\Path::getList());
		$this->mapInstance->setWidth(700);
		
		$taskManager = \Game\Task\i::Manager();
		$taskManager->loadAll();
		
		// Ausschreibung laden
		$this->taskID = isset($options['taskID']) ? $options['taskID'] : -1;
		$this->task = $taskManager->existObjectForID($this->taskID) ? $taskManager->getObjectForID($this->taskID) : false;
		
		// Bewerbung laden
		$taskApplicationList = $this->si()->issetVarCache('taskApplications') ? $this->si()->getVarCache('taskApplications') : array();
		$this->taskApplication = isset($taskApplicationList[$this->taskID]) ? $taskApplicationList[$this->taskID] : false;
		
		// Bewerbung überprüfen
		$this->checkApplication();
			
		// Eventuelle Auswahlen, die in der Bewerbung schon vorhanden sind, übernehmen
		if(is_object($this->taskApplication->getPathUnit())) {
			$this->pathUnits = array($this->taskApplication->getPathUnit());
			$this->selectedStations = $this->taskApplication->getPathUnit()->getStations();
		}
		
		// Aufgaben dieses Modules ausführen
		$this->mi()->addVarCache('task', $this->task);
		$this->mi()->addVarCache('taskID', $this->taskID);
		
		$sendOptions = $options;
		$sendOptions['makeAction'] = true;
		$sendOptions['stationIDs'] = '';
		$this->mi()->addVarCache('mapSendOptions',$sendOptions);
		
		try {
			if(isset($options['makeAction']) && $options['makeAction'] && isset($options['stationIDs']))
				$this->selectTracks($options['stationIDs']);
		} catch(HumanException $exception) {
			$this->mi()->addVarCache('showError', true);
			$this->mi()->addVarCache('errorString', $exception->getMessage());
		}
		
		$this->mapInstance->setSelectable(true);
		
		// Die ausgewählten Bahnhöfe darstellen
		$this->mapInstance->setHighlightedStations($this->selectedStations,$this->task->getStations());
		
		// Wenn bereits Strecken-Verbünde gespeichert sind, diese markieren
		$paths = array();
		foreach($this->pathUnits as $currentPathUnit) {
			// Die einzelnen Strecken aus den Strecken-Verbünden auslesen
			foreach($currentPathUnit->listPaths() as $currentPath) $paths[] = $currentPath;
		}
		$this->mapInstance->setSelectedPaths($paths);
		
		// Die Karte zeichnen
		$this->mi()->addVarCache('svgMap', $mapInstance->draw());
	}
	
	/**
	* Überprüft die Bewerbung
	**/
	private function checkApplication() {
		// Die Ausschreibung nicht (mehr) vorhanden?
		if($this->task === false)
			Module::goToModule('Game_Tasks', array('currentTask'=>'invalid'));
	
		try {
			if($this->taskApplication === false)
				throw new \HumanException();
		
			$this->taskApplication->checkTrainUnit($this->task, lsi()->getUserInstance());
		} catch (\HumanException $exception) {
			Module::goToModule('Game_Tasks', array('currentTaskApplicaton'=>'invalid'));
		}
	}
	
	/**
	* Versucht die Strecken, die ausgewählt wurden, zu ermitteln
	*
	* @param String $stationIDs - Die IDs der Bahnhöfe als String.
	**/
	private function selectTracks($stationIDs) {
		$this->selectedStations = $this->getStationsInString($stationIDs);	
		$this->pathUnits = array();
		
		$this->pathUnits = \Game\Path\Unit::getPathUnitsToConnectStations($this->selectedStations);
			
		if(count($this->pathUnits) > 2)
			throw new \HumanException('Du hast keine durchgehende Strecke ausgewählt.', -1);
			
		$bestPathUnit = $this->task->getBestPathUnit($this->pathUnits);
			
		$this->pathUnits = array($bestPathUnit);
			
		$this->taskApplication->setPathUnit($bestPathUnit);
		$this->taskApplication->checkPathUnit($this->task, $this->ui());
			
		// Wenn alles okay ist, weiterleiten.
		Module::goToModule('Game_Tasks_Application',array('taskID'=>$this->taskID));
	}
	
	/**
	* Bekommt die Bahnhofs-Elemten aus dem Bahnhofs-ID-String.
	*
	* @param string $idString - Der String mit den Bahnhofs-IDs
	* @return array[Station] - Array mit den ausgewählten Bahnhöfen
	**/
	private function getStationsInString($idString) {
		$idsWithString = explode(' ',$idString);
		$stations = array();
		
		foreach($idsWithString as $currentString) {
			$currentString = str_replace('stationID', '', $currentString);

			if(is_numeric($currentString) && \Game\Station::existObjectForID($currentString))
				$stations[] = \Game\Station::getObjectForID($currentString);
		}
		
		return $stations;
	}	
		
}
?>