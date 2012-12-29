<?php
/**
*
* Verwaltet die Strecken zwischen den Bahnhöfen
* Datum: 6. November 2012
*
**/
namespace Game;

class Path extends Data {
	use \Core\Data\Vars;
	
	protected static $pathsFromStation = array();
	
	const GROUP_MAIN = 0;
	const GROUP_SMALL = 1;
	
	/**
	* Eigene Methode zum hinzufügen von Objekten.
	* Vereinfacht das spätere finden von Strecken von einem Bahnhof zu einem anderen
	*
	* @param int $id - Eine ID für die Daten.
	* @param self $object - Ein neues Objekt
	* @param bool $group - Die Gruppe des Objekts [optional]
	**/
	public static function addObject($id, $object, $group=false) {
		parent::addObject($id, $object, $group);
		
		$startStationID = $object->getStartStation()->getID();
		$endStationID = $object->getEndStation()->getID();
		 
		if(!isset(self::$pathsFromStation[$startStationID])) self::$pathsFromStation[$startStationID] = array();
		self::$pathsFromStation[$startStationID][$endStationID] = $object; 
	}
	
	/**
	* Existiert ein Pfad von dem einem Bahnhof zum anderen?
	*
	* @param Station $firstStation - Erster Bahnhof
	* @param Station $secondStation - Zweiter Bahnhof
	* @return bool - Ja oder nein?
	**/
	public static function existPathFromStationToStation(Station $firstStation, Station $secondStation) {
		$firstStationID = $firstStation->getID();
		$secondStationID = $secondStation->getID();
		
		return isset(self::$pathsFromStation[$firstStationID][$secondStationID])
				|| isset(self::$pathsFromStation[$secondStationID][$firstStationID]);
	}
	
	/**
	* Gibt den Pfad von einem Bahnhof zu einem anderen aus.
	*
	* @param Station $firstStation - Erster Bahnhof
	* @param Station $secondStation - Zweiter Bahnhof
	* @return Path - Die Strecke
	**/
	public static function getPathFromStationToStation(Station $firstStation, Station $secondStation) {
		if(!self::existPathFromStationToStation($firstStation, $secondStation))
			throw new \HumanException('Es existiert keine Strecke zwischen den beiden Bahnhöfen.', 2020);
		
		$firstStationID = $firstStation->getID();
		$secondStationID = $secondStation->getID();	
		
		if(isset(self::$pathsFromStation[$firstStationID][$secondStationID]))
			return self::$pathsFromStation[$firstStationID][$secondStationID];
		else
			return self::$pathsFromStation[$secondStationID][$firstStationID];
	}
	
	/**
	* Setzt den Start-Bahnhof der Strecke
	*
	* @param int $startStationID - ID des Startbahnhofs
	**/
	public function setStartStation($startStationID) {
		$this->properties['startStationID'] = $startStationID;
	}
	
	/**
	* Gibt den Start-Bahnhof der Strecke zurück
	*
	* @return Station - Bahnhofs-Objekt
	**/
	public function getStartStation() {
		return Station::getObjectForID($this->properties['startStationID']);
	}
	
	/**
	* Setzt den End-Bahnhof der Strecke
	*
	* @param int $setEndStationID - ID des Startbahnhofs
	**/
	public function setEndStation($endStationID) {
		$this->properties['endStationID'] = $endStationID;
	}
	
	/**
	* Gibt den End-Bahnhof der Strecke zurück
	*
	* @return Station - Bahnhofs-Objekt
	**/
	public function getEndStation() {
		return Station::getObjectForID($this->properties['endStationID']);
	}
	
	/**
	* Setzt den Kurvigkeits-Faktor der Strecke
	*
	* @param float $twistingFactor - Kurvigkeit der Strecke
	**/
	public function setTwistingFactor($twistingFactor) {
		$this->properties['twistingFactor'] = $twistingFactor;
	}
	
	/**
	* Gibt die Kurvivkeit der Strecke zurück
	*
	* @return float - Kurven
	**/
	public function getTwistingFactor() {
		return $this->properties['twistingFactor'];
	}
	
	/**
	* Setzt die Länge eines Strecken-Teiles.
	*
	* @param int $length - Länge in km
	**/
	public function setLength($length) {
		$this->properties['length'] = $length;
	}
	
	/**
	* Gibt die Länge der Strecke zurück
	*
	* @return int - Länge in km
	**/
	public function getLength() {
		return $this->properties['length'];
	}
	
	/**
	* Setzt die max Geschwindigkeit auf dieser Strecke.
	*
	* @param int $maxSpeed - Maximal Geschwindigkeit in km/h
	**/
	public function setMaxSpeed($maxSpeed) {
		$this->properties['maxSpeed'] = $maxSpeed;
	}
	
	/**
	* Gibt die max Geschwindigkeit zurück
	*
	* @return int - Maximal Geschwindigkeite in km/h
	**/
	public function getMaxSpeed() {
		return $this->properties['maxSpeed'];
	}
	
	/**
	* Gibt an ob die Strecke elektrifiziert ist
	*
	* @param bool $electrified - Elektrifiziert?
	**/
	public function setElectrified($electrified) {
		$this->properties['electrified'] = $electrified;
	}
	
	/**
	* Gibt zurück, ob die Strecke elektrifiziert ist
	*
	* @return bool - Elektrifiziert?
	**/
	public function isEletrified() {
		return $this->properties['electrified'];
	}
	
	/**
	* Berechnet die Pfad-Vektoren
	*
	* @return array - Die Vektoren
	**/
	private function calcStepVectors() {
		$startStation = $this->getStartStation();
		$endStation = $this->getEndStation();
		$twistingFactor = $this->getTwistingFactor();
	
		$ax = $startStation->getX();
		$ay = $startStation->getY();
		$bx = $endStation->getX();
		$by = $endStation->getY();
	
		// Den Vektor zwischen Punkt a und Punkt b ausrechnen
		$vector = array();
		$vector[0] = $bx - $ax;
		$vector[1] = $by - $ay;
		
		// Wie lang ist der Vektor?
		$pathLength = sqrt($vector[0]*$vector[0]+$vector[1]*$vector[1]);
		// Den Kurvigkeits-Faktor mit der Länge der Strecke verbinden
		$improvedTwistingFactor = $pathLength * $twistingFactor;
		// Anzahl der Kurven ausrechnen
		$steps = ceil($pathLength / 10);
		// Stärke der Abweichung von der geraden Strecke ausrechnen
		$randFactor = $improvedTwistingFactor / 4;
		$minDif = $randFactor / 4;
		
		$lineVectors = array();
		$lastVector = array(0,0);
		// Start der Linie an Punkt a
		$stepVectors[] = array($ax,$ay);
		for($i = 0; $i < $steps; $i++) {
			// Vektor vom Ursprung zur $i-sten Kurve ausrechnen
			$stepVector = array();
			$stepVector[0] = $ax + ($vector[0] / $steps) * $i;
			$stepVector[1] = $ay + ($vector[1] / $steps) * $i;
			
			// Abweichungsvektor ausrechnen (Abweichung zur gerade Linie.)
			$randVector = array();
			$randomDif = false; 
			do {
				$randVector[0] = mt_rand(-$randFactor,$randFactor);
				$randVector[1] = mt_rand(-$randFactor,$randFactor);
				
				// Wenn der Vektor dem vorheringen nicht gleich ist, Schleife abrechen.
				if(!($lastVector[0] > $randVector[0] && $lastVector[0] < $randVector[0]+$minDif &&
					$lastVector[1] > $randVector[1] && $lastVector[1] < $randVector[1]+$minDif) &&
					!($lastVector[0] < $randVector[0] && $lastVector[0] > $randVector[0]-$minDif &&
					$lastVector[1] < $randVector[1] && $lastVector[1] > $randVector[1]-$minDif)) $randomDif = true;
			} while(!$randomDif);
			
			// Abweichungen am Rand minimieren (Sonst sieht es manchmal hässlich aus.)
			$randVector[0] *= ($i+1)/$steps;
			$randVector[1] *= ($i+1)/$steps;
			
			// Kurven-Vektor mit dem Abweichungsvektor addieren
			$stepVector[0] += $randVector[0];
			$stepVector[1] += $randVector[1];
			
			// Kurven-Vektor im Array speichern.
			$stepVectors[] = array(round($stepVector[0]),round($stepVector[1]));
			
			// Zufallsvektor zwischenspeichern
			$lastVector = $randVector;
		}
		// Ende der Linie an Punkt b
		$stepVectors[] = array($bx,$by);
		
		return $stepVectors;
	}
	
	/**
	* Gibt die Pfad-Vektoren als Array zurück
	*
	* @return array - Die Vektoren
	**/
	public function getStepVectors() {
		$pathCache = \Core\i::CacheFile('paths');
		$cachedDate = $pathCache->issetVar($this->getID()) ? $pathCache->getVar($this->getID()) : array();

		if(isset($cachedDate['twistingFactor']) && $cachedDate['vectorArray'] && $cachedDate['twistingFactor'] == $this->getTwistingFactor())
			return $cachedDate['vectorArray'];
		else {
			$vectorArray = $this->calcStepVectors();
			
			$cachedDate['vectorArray'] = $vectorArray;
			$cachedDate['twistingFactor'] = $this->getTwistingFactor();
			$pathCache->setVar($this->getID(), $cachedDate);
			
			return $vectorArray;
		}
	}
	
	/**
	* Berechnet die Zeit, die gegebene Zugeinheit auf der Strecke braucht.
	*
	* @param TrainUnit $trainUnit - Zugeinheit
	* @param int $weightType - Leergewicht, aktuelles Gewicht oder max Gewicht?
	* @param int $startSpeed - Startgeschwindigkeit [optional]
	* @param int $endSpeed - Welche Geschwindigkeit muss er am Ende der Strecke haben? (Übergang auf neue Strecke? Halt?)
	* @return array('reachedSpeed' => Erreichte Geschwindigkeit, 'time' => Benötigte Zeit)
	**/
	public function calcTimeWithTrainUnit(Train\Unit $trainUnit, $weightType, $startSpeed = 0, $endSpeed = 0) {
		// Daten für die Berechnungen zwischenspeichern
	 	$speedup = $trainUnit->getSpeedup($weightType);
	 	$delay = -$speedup;
	 	$maxSpeed = $trainUnit->getSpeed();
	 	$distance = $this->getLength();
	 	$twinstingFactor = $this->getTwistingFactor();
	 	
	 	// Die Strecke hat eine kleinere Vmax als der Zug? Dann diese nehmen!
	 	if($this->getMaxSpeed() < $maxSpeed) $maxSpeed = $this->getMaxSpeed();
	 	// Der Zug fährt bereits mehr als erlaubt? Dann runter bremsen, erstmal Verzögerungszeit vernachlässigen.
	 	//	Solle sowieso nicht vorkommen.
	 	if($startSpeed > $maxSpeed) $startSpeed = $maxSpeed;
	 	
	 	// Der Zug kann die End-Geschwindigkeit auf dieser Strecke nicht erreichen? Dann endSpeed = maxSpeed.
	 	if($endSpeed > $maxSpeed) $endSpeed = $maxSpeed;
	 	
	 	// Maximal-Geschwindigkeit in m/s umrechnen
	 	$maxSpeed *= 1000/60/60;
	 	// Start-Geschwindigkeit in m/s umrechnen
	 	$startSpeed *= 1000/60/60;
	 	// End-Geschwindigkeit in m/s umrechnen
	 	$endSpeed *= 1000/60/60;
	 	// Die Länge der Strecke in m umrechnen
	 	$distance *= 1000;
	 	
	 	// Wie viel Geschwindigkeit müssen wir überhaupt zunehmen?
	 	$difStartSpeed = $maxSpeed - $startSpeed;
	 	// Wie viel müssen wir am Ende wieder abbremsen?
	 	$difEndSpeed = $endSpeed - $maxSpeed;
	 	
	 	// Erstmal davon ausgehen, dass die gewünschte Endgeschwindigkeit auch erreicht wird
	 	$reachedSpeed = $endSpeed;
	 	
	 	// Welche Strecke brauchen wir zum Beschleunigen?
	 	$speedupDistance = 0.5 * $speedup * pow($difStartSpeed / $speedup,2);
	 	// Wie viel Zeit wäre das denn?
	 	$speedupTime = sqrt((2 * $speedupDistance) / $speedup);
		
		// Welche Strecke brauchen wir zum Verzögern?
		$delayDistance = 0.5 * $delay * pow($difEndSpeed / $delay,2);
		// Wie lange brauchen wir dafür?
		$delayTime = sqrt((2 * $delayDistance) / $delay);	 
		
		// Weg mit variabler Geschwindigkeit
	 	$varTime = $speedupTime + $delayTime;
	 	// Zeit mit variabler Geschwindigkeit
	 	$varDistance = $speedupDistance + $delayDistance;	
	 	
	 	// Die Beschleunigungs- und Verzögerungs-Strecken zusammen sind länger als die Strecke selbst?
	 	//	Erstmal „praktische“ Vmax ausrechnen.
	 	if($varDistance > $distance) {
			// Steigung der Beschleunigung ausrechnen
			$mSpeedup = ($maxSpeed - $startSpeed) / $speedupDistance;
			// Steigung der Verzögerung ist -$mSpeedup
			$mDelay = -$mSpeedup;
			// n-Wert der Verzögerungs-Gerade
			$nDelay = $endSpeed - ($mDelay * $distance);
		
			// Schnittpunkt zwischen der Beschleunigungs- und der Verzögerungs-Gerade (X-Wert)
			$speedupDistance = ($startSpeed - $nDelay) / (-2 * $mSpeedup);
			
			// Der Schnittpunkt liegt außerhalbe der Strecke. Sprich: Gewünschte Endgeschwindigkeit wird nie erreicht.
			if ($speedupDistance > $distance) {			
				// Wie viel können wir auf dieser Strecke überhaupt maximal schaffen?
				$maxPossibleSpeed = $mSpeedup * $distance + $startSpeed;
				// Das ist auch die autoamtisch die erreichte Endgeschwindigkeit
				$reachedSpeed = $maxPossibleSpeed;
				// Wie lange brauche ich denn für das Beschleunigen auf diese Geschwindigkeit?
				$fullTime = sqrt((2 * $distance) / $speedup);
			} else {
				// Welche Strecke müssen wir Beschleunigen?
				$delayDistance = $distance - $speedupDistance;
			
				// Beschleunigungs-Zeit
				$speedupTime = sqrt((2 * $speedupDistance) / $speedup);
				// Verzögerungs-Zeit
				$delayTime = sqrt((2 * $delayDistance) / $delay);
			
				// Gesamtzeit ist Beschleunigungs und Verzögerungszeit
				$fullTime = $speedupTime + $delayTime;
			}
			
		// Die Beschleunigungs- und Verzögerungs-Strecken zusammen sind kürze als die gesamte Strecke?
		//	Streckenanteil mit konstanter Geschwindigkeit noch dazurechnen
	 	} else if($varDistance < $distance) {
	 	 	// Was für eine Strecke bleibt noch übrig?
		 	$remainDistance = $distance - $varDistance;
		 	// Wie lange brauch’ ich für diese Strecke?
		 	$remainTime = $remainDistance / $maxSpeed;
		 			 	
		 	// Wie lange brauch’ ich denn jetzt ingesamt?
		 	$fullTime = $varTime + $remainTime;
		
		// Die Beschleunigungs- und Verzögerungs-Strecken zusammen sind genauso lange wie die Strecke?
		//	Ganz einfach!
	 	} else
	 	 	$fullTime = $varTime;
	 	
	 	// Den Kurvigkeitsfaktor noch einfließen lassen. Mal schauen, ob das so gut ist.
	 	$fullTime /= pow($twinstingFactor, $twinstingFactor);
	 	
	 	// Erreichte Geschwindigkeit in km/h umrechnen (liegt in m/s vor)
	 	$reachedSpeed /= 1000/60/60;
	 	
	 	$time = new \Core\TimeDuration(round($fullTime));
	 	return array('reachedSpeed'=>$reachedSpeed, 'time'=>$time);
	}

}
?>