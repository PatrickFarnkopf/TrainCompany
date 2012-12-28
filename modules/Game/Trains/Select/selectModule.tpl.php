<? if(!defined('INC')) exit; ?>
<? mit('currentTask',array('task'=>cmi()->getVarCache('task'))) ?>
<fieldset class="RightBox">
	<legend>Fahrzeugwahl</legend>
	Du musst die Zugeinheit wählen, mit der du die Ausschreibung ausführen willst.
	Es werden dir nur Fahrzeuge angezeigt, die grundsätzlich genug Kapazität für diese Ausschreibung aufweisen.
</fieldset>
<div class="Clear"></div>

<form method="post" action="<?= cml('game_trains_select', array('taskID'=>cmi()->getVarCache('taskID'),'makeAction'=>true)) ?>">
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
		<? foreach(cmi()->getVarCache('trainUnitGroups') as $groupID => $currentGroup): ?>
			<tr>
				<th colspan="7"><?= Format::string($currentGroup->getName()) ?></th>
			</tr>
			<? $currentTrainUnitList = lsi()->getUserInstance()->listTrainUnits($groupID) ?>
			<? $i = 1 ?>
			<? foreach($currentTrainUnitList as $key=>$currentTrainUnit): ?>
				<? if(cmi()->getVarCache('task')->isCompatibleTrainUnit($currentTrainUnit)): ?>
					<? $i ++ ?>
					<? $selected = cmi()->issetVarCache('selectedUnit') ? cmi()->getVarCache('selectedUnit') == $key : $first ?>
					<? mit('currentTrainUnit',array('tableRow'=>$i%2,'trainUnit'=>$currentTrainUnit,'trainUnitID'=>$key, 'radioButton'=>true, 'selected'=>$selected)) ?>
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