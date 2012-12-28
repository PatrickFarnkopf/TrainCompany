<? ^^^('currentTask',array('task'=>!!!task!!!)) ?>
<fieldset class="RightBox">
	<legend>Fahrzeugwahl</legend>
	Du musst die Zugeinheit wählen, mit der du die Ausschreibung ausführen willst.
	Es werden dir nur Fahrzeuge angezeigt, die grundsätzlich genug Kapazität für diese Ausschreibung aufweisen.
</fieldset>
<div class="Clear"></div>

<form method="post" action="<?= >>>(NULL, array('taskID'=>!!!taskID!!!,'makeAction'=>true)) ?>">
	<? $first = true; ?>
	<table class="OverviewTable">
		<tr>
			<th width="180">Bestandteile</th>
			<th>Vmax</th>
			<th>Gewicht</th>
			<th>Länge</th>
			<th>Kapazität</th>
			<th>Antrieb</th>
			<th></th>
		</tr>
		<? foreach(!!!trainUnitGroups!!! as $groupID => $currentGroup): ?>
			<tr>
				<th colspan="7"><?= Format::string($currentGroup->getName()) ?></th>
			</tr>
			<? $i = 1 ?>
			<? foreach(!!!trainUnits!!![$groupID] as $key=>$currentTrainUnit): ?>
				<? if(!!!task!!!->isCompatibleTrainUnit($currentTrainUnit)): ?>
					<? $i ++ ?>
					<? $selected = ???selectedUnit??? ? !!!selectedUnit!!! == $key : $first ?>
					<? ^^^('currentTrainUnit',array('tableRow'=>$i%2,'trainUnit'=>$currentTrainUnit,'trainUnitID'=>$key, 'radioButton'=>true, 'selected'=>$selected)) ?>
					<? $first = false; ?>
				<? endif; ?>
			<? endforeach; ?>
			<? if($i == 1): ?>
				<tr>
					<td colspan="7" class="Center">Du hast in dieser Fahrzeug-Gruppe keine Fahrzeuge, die zu dieser Ausschreibung passen.</td>
				</tr>
			<? endif; ?>
		<? endforeach; ?>
	</table>

	<input type="submit" value="&laquo; Zurück" name="back" class="Left">
	<input type="submit" value="Fahrzeug auswählen &raquo;" name="select" class="Right">
	<div class="Clear"></div>
</form>