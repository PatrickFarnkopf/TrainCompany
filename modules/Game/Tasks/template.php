<fieldset>
	<legend>Ausschreibungs-Übersicht</legend>
	Hier siehst du eine Übersicht über alle aktuellen Ausschreibungen und kannst deine Angebote vorlegen.
	Bevor du dich für eine Ausschreibung bewirbst solltest du dir den Beschreibungs-Text gut durchlesen.
</fieldset>

<div id="groupList">
	<ul>
		<li>&raquo;Neue Ausschreibungen&laquo;</li>
		<li>&middot;</li>
		<li><a href="<?= >>>('Game_Tasks_Active', [], 'groupList') ?>">Aktive Ausschreibungen</a></li>
	</ul>
</div>

<form method="post" action="<?= >>>(NULL, ['makeAction'=>true]) ?>">
	<? if(count(!!!taskList!!!) == 0): ?>
		<p class="Center">
			Derzeit existieren keine Ausschreibungen, die du erfüllen könntest.
		</p>
	<? endif; ?>
	<? foreach(!!!taskList!!! as $taskID => $currentTask): ?>
		<div class="Task">
			<h1><?= Format::string($currentTask->getTitle()) ?></h1>
			<blockquote>
				<div><?= Format::string($currentTask->getDescription()) ?></div>
			</blockquote>
			<p class="LeftAlign">
				Benötigte Kapazitäten:
				<? foreach($currentTask->getNeededCapacity() as $currentCapacity=>$value): ?>
					<? $currentCapacityObject = \Game\Capacity::getObjectForID($currentCapacity) ?>
					<img src="img/icons/<?= $currentCapacityObject->getIcon() ?>" alt="<?= $currentCapacityObject->getName() ?>" title="<?= $currentCapacityObject->getName() ?>">
					<? if($value>0): ?>
						<? $unit = $currentCapacityObject->getUnit() ?>
						<? if(!empty($unit)): ?>
							<?= Format::unit(Format::number($value),$unit) ?>
						<? else: ?>
							<?= Format::number($value) ?>
						<? endif; ?>
					<? endif; ?>
				<? endforeach; ?>
			</p>
			<span class="Left">
				<img src="img/icons/money_add.png" alt="Plops" title="Plops">
				<span class="Green"><?= Format::number($currentTask->getPlops()) ?></span>
			</span>
			<span class="Right">
				<? if($currentTask->getType() == \Game\Task::WITH_APPLICATION): ?>
					<? if($currentTask->countApplicationsWithoutUser(!!!currentUserInstance!!!) == 1): ?>
						<em>(ein anderer)</em>
					<? else: ?>
						<em>(<?= Format::number($currentTask->countApplicationsWithoutUser(!!!currentUserInstance!!!)) ?> andere)</em>
					<? endif; ?>
					<? if($currentTask->existApplicationForUser(!!!currentUserInstance!!!)): ?>
						Noch <?= $currentTask->getTimeTillEndTime() ?> Stunden
					<? else: ?>
						<input type="submit" name="takeTask[<?= $taskID ?>]" value="Angebot erstellen &raquo;">
					<? endif; ?>
				<? else: ?>
					<input type="submit" name="takeTask[<?= $taskID ?>]" value="Aufgabe ausführen &raquo;">
				<? endif; ?>
			</span>
			<div class="Clear"></div>
		</div>
	<? endforeach; ?>
</form>

<div class="Clear"></div>