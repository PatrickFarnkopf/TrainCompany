<? ^^^('currentTask',['task'=>!!!task!!!]) ?>
<fieldset class="RightBox">
	<legend>Fahrplan festlegen</legend>
	Auf dieser Seite musst du den Fahrplan deines Zuges festlegen.
	Plane genug Pufferzeit ein, damit der Zug bei Verzögerungen im Betriebsablauf die Verspätung wieder rausholen kann.
</fieldset>
<div class="Clear"></div>
<fieldset>
	<legend>Bedingungen</legend>
	Folgende Punkte müssen bei der Wahl beachtet werden:
	<ul>
		<li>Der Zug darf nicht Abfahren, bevor an an diesem Bahnhof angekommen ist.</li>
		<li>Die Ankunft an einem Bahnhof muss nach der Abfahrt bei dem vorherigen Bahnhof stattfinden.</li>
	</ul>
</fieldset>

<form method="post" action="<?= >>>(NULL, ['taskID'=>!!!taskID!!!,'makeAction'=>true]) ?>">
	<table class="OverviewTable">
		<tr>
			<th width="250" rowspan="2" height="40">Stationen</th>
			<th colspan="2">Errechnete Ankunft</th>
			<th colspan="2">Planmäßige</th>
		</tr>
		<tr>
			<th>leer</th>
			<th>voll</th>
			<th>Ankunft</th>
			<th>Abfahrt</th>
		</tr>
		<? foreach(!!!stations!!! as $list => $currentStation): ?>
			<tr class="Table<?= $list%2 ?>">
				<td><?= Format::string($currentStation->getName()) ?></td>
				<td class="Center">
					<? if($list>0): ?>
						<?= !!!arrivalTimes!!!['empty'][$currentStation->getID()] ?>
					<? else: ?>
						<?= new \Core\TimeDuration() ?>
					<? endif; ?>
				</td>
				<td class="Center">
					<? if($list>0): ?>
						<?= !!!arrivalTimes!!!['max'][$currentStation->getID()] ?>
					<? else: ?>
						<?= new \Core\TimeDuration() ?>
					<? endif; ?>
				</td>
				<? if(in_array($currentStation, !!!neededStations!!!)): ?>
					<td class="Center">
						<? if($list > 0): ?>
							<input type="text" style="width: 15px;" onkeyup="JumperInput(this)"  maxlength="2" placeholder="00" name="<?= $currentStation->getID() ?>[arrival][60]"
								<? if(!!!taskSchedule!!!->existTimesForStation($currentStation)): ?>
									value="<?= !!!taskSchedule!!!->getTimesForStation($currentStation)['arrival']->getHours() ?>"
								<? endif; ?>
							> :
							<input type="text" style="width: 15px;" onkeyup="JumperInput(this)"  maxlength="2" placeholder="00" name="<?= $currentStation->getID() ?>[arrival][1]"
								<? if(!!!taskSchedule!!!->existTimesForStation($currentStation)): ?>
									value="<?= !!!taskSchedule!!!->getTimesForStation($currentStation)['arrival']->getMinutes() ?>"
								<? endif; ?>
							>
						<? else: ?>
							-
						<? endif; ?>
					</td>
					<td class="Center">
						<? if($list == 0): ?>
							<?= new \Core\TimeDuration() ?>
						<? elseif($list < count(!!!stations!!!)-1): ?>
							<input type="text" style="width: 15px;" onkeyup="JumperInput(this)"  maxlength="2" placeholder="00" name="<?= $currentStation->getID() ?>[departure][60]"
								<? if(!!!taskSchedule!!!->existTimesForStation($currentStation)): ?>
									value="<?= !!!taskSchedule!!!->getTimesForStation($currentStation)['departure']->getHours() ?>"
								<? endif; ?>
							> :
							<input type="text" style="width: 15px;" onkeyup="JumperInput(this)"  maxlength="2" placeholder="00" name="<?= $currentStation->getID() ?>[departure][1]"
								<? if(!!!taskSchedule!!!->existTimesForStation($currentStation)): ?>
									value="<?= !!!taskSchedule!!!->getTimesForStation($currentStation)['departure']->getMinutes() ?>"
								<? endif; ?>
							>
						<? else: ?>
							-
						<? endif; ?>
					</td>
				<? else: ?>
					<td colspan="2" class="Center">- kein Halt -</td>
				<? endif; ?>
			</tr>
		<? endforeach; ?>	
	</table>

	<? if(!!!task!!!->getType() == \Game\Task::WITH_APPLICATION): ?>
		<input type="submit" value="Bewerbung einreichen &raquo;" name="select" class="Right">
	<? else: ?>
		<input type="submit" value="Zug losschicken &raquo;" name="select" class="Right">
	<? endif; ?>
	<input type="submit" value="&laquo; Zurück" name="back" class="Left">
	<div class="Clear"></div>
</form>