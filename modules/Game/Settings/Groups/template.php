<table class="LeftTable">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Einheiten</th>
		<th>Optionen</th>
	</tr>
	<? $i = 0 ?>
	<? foreach(!!!trainUnitGroups!!! as $groupID => $currentTrainUnitGroup): ?>
		<? $i ++?>
		<tr class="Table<?= $i%2 ?>">
			<td class="Center"><?= Format::number($groupID) ?></td>
			<td>
				<? if(!!!editGroup!!! == $groupID): ?>
					<form method="post" action="<?= >>>(NULL, ['makeAction'=>'saveEdit','groupID'=>$groupID]) ?>">
						<input name="groupName" type="text" value="<?= Format::string($currentTrainUnitGroup->getName()) ?>" size="15">
						<input type="submit" value="OK">
					</form>
				<? else: ?>
					<?= Format::string($currentTrainUnitGroup->getName()) ?>
				<? endif; ?>
			</td>
			<td class="Center"><?= Format::number($currentTrainUnitGroup->countIDs()) ?></td>
			<td class="Center">
				<? if($groupID == 0): ?>
					-
				<? else: ?>
					<a href="<?= >>>(NULL, ['makeAction'=>'edit','groupID'=>$groupID]) ?>"><img src="img/icons/pencil.png"></a>
					<a href="<?= >>>(NULL, ['makeAction'=>'delete','groupID'=>$groupID]) ?>"><img src="img/icons/delete.png"></a>
				<? endif; ?>
			</td>
		</tr>
	<? endforeach; ?>
</table>

<fieldset class="RightBox">
	<legend>Neue Fahrzeuggruppe</legend>
	<form method="post" action="<?= >>>(NULL, ['makeAction'=>'new']) ?>">
		<label for="groupName">Name der Gruppe:</label>
		<input type="text" name="groupName" id="groupName">
		
		<div class="Clear"></div>
		<input type="submit" value="Gruppe erstellen">
	</form>
</fieldset>

<div class="Clear"></div>