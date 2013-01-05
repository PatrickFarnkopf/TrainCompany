<? ^^^('currentTask',['task'=>!!!task!!!]) ?>
<fieldset class="RightBox">
	<legend>Streckenwahl</legend>
	Auf dieser Karte musst du die Strecke deines Zuges wählen.
	Versuche die schnellste Verbindung zu wählen, diese Wahl hat direkt Einfluss auf die Fahrplan-Zeiten.
</fieldset>
<div class="Clear"></div>
<fieldset>
	<legend>Bedingungen</legend>
	Folgende Punkte müssen bei der Wahl beachtet werden:
	<ul>
		<li>Damit die Strecke ermittelt werden kann, müssen Start- und Endbahnhof jedes Streckeabschnitts ausgewählt werden.</li>
		<li>Am Ende muss dadurch eine durchgehende Strecke entstehen, welche beim ersten markierten Bahnhof anfängt und beim letzten endet.</li>
		<li>Alle markierten Bahnhöfe müssen angefahren werden.</li>
		<li>Die Strecke muss mit dem ausgewählten Zug kompatibel sein. (Sprich: Keine E-Züge auf unelektrifizierten Strecken.)</li>
	</ul>
</fieldset>

<div class="Center">
	<? ^^^('mapView',['mapContent'=>!!!svgMap!!!]) ?>
</div>

<button class="Left" onclick="window.location.href='<?= >>>('Game_Trains_Select',['taskID'=>!!!taskID!!!]) ?>'">
	&laquo; Zurück
</button>
<button class="Right" onclick="sendStations('<?= >>>(NULL,!!!mapSendOptions!!!) ?>')">
	Strecken auswählen &raquo;
</button>
<div class="Clear"></div>