<fieldset>
	<legend>Fahrzeug-Übersicht</legend>
	Auf dieser Seite findest du eine Tabelle mit deinen Zugverbünden. Du kannst Zugverbünde kombinieren, trennen oder ganz verkaufen:
	<ul>
		<li>
			Beim Koppeln von Zugeinheiten werden alle Züge zu einer gemeinsame Zugeinheit verbunden. Dabei gibt es folgende Regeln:
			<ol>
				<li>Triebzüge können nur mit sich selbst verbunden werden.</li>
				<li>Ein Diesel-Antrieb-Fahrzeug kann mit keinem Elektro-Antrieb-Fahrzeug verbunden werden.</li>
				<li>Die gesamte Einheit darf nicht länger als <?= Format::unit(Format::number(!!!maxTrainLength!!!),'m') ?> werden.</li>
				<li>Einige Triebzüge lassen sich nur x-mal miteinander koppeln.</li>
			</ol>
		</li>
		<li>Beim Verkaufen bekommst du, ja nach Alter der Fahrzeuge, einen Anteil des Kaufpreises zurück.</li>
		<li>Um eine Einheit zu teilen, klicke auf das <img src="img/icons/link.png" alt="gekuppelt" title="gekuppelt" width="12">-Symbol, an der Stelle, an der du die Einheit teilen möchtest.</li>
		<li>Die Beschleunigung der Züge ist abhängig von der Witterung. Die angezeigten Beschleunigungswerte gehen von der aktuellen Witterung aus.</li>
		<li>Um weitere Informationen über einzelne Fahrzeuge zu bekommen, kannst du mit der Maus über deren Namen fahren.</li>
	</ul>
	<a href="<?= >>>('Game_Trains_Buy') ?>">&raquo; Neue Fahrzeuge kaufen</a>
</fieldset>

<div id="groupList">
	<ul>
		<? foreach(!!!trainUnitGroups!!! as $groupID => $currentTrainUnitGroup): ?>
			<? if($groupID > 0): ?>
				<li>&middot;</li>
			<? endif; ?>
			<li>
				<? if($groupID == !!!currentUnitGroupID!!!): ?>
					&raquo;<?= Format::string($currentTrainUnitGroup->getName()) ?>&laquo;
				<? else: ?>
					<a href="<?= >>>(NULL, array('groupID' => $groupID),'groupList') ?>"><?= Format::string($currentTrainUnitGroup->getName()) ?></a>
				<? endif; ?>
			</li>
		<? endforeach; ?>
	</ul>
</div>

<form method="post" name="trainList" action="<?= >>>(NULL, array('makeAction'=>true,'groupID' => !!!currentUnitGroupID!!!)) ?>">
	<table class="OverviewTable">
		<tr>
			<th width="180">Bestandteile</th>
			<th>Vmax</th>
			<th>Gewicht</th>
			<th>Länge</th>
			<th>Kapazität</th>
			<th>Antrieb</th>
			<th>Verkaufswert</th>
			<th><input type="checkbox" id="mainCheck"  onclick="check();"></th>	
		</tr>
		<? if(count(!!!trainUnits!!!)>0): ?>
			<? $i = 1 ?>
			<? foreach(!!!trainUnits!!! as $key=>$currentTrainUnit): ?>
				<? $i ++ ?>
				<? ^^^('currentTrainUnit',array('tableRow'=>$i%2,'trainUnit'=>$currentTrainUnit,'trainUnitID'=>$key,'splitUpModule'=>'game_trains','splitUpOptions'=>array('splitUp'=>true,'trainUnit'=>$key,'groupID'=>!!!currentUnitGroupID!!!), 'showSalePrice'=>true)) ?>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan="8" class="Center">Du hast in dieser Fahrzeuggruppe derzeit keine Fahrzeuge.</td>
			</tr>
		<? endif; ?>
	</table>
	
	<span class="Left">
		<select name="groupID">
			<? foreach(!!!trainUnitGroups!!! as $groupID => $currentTrainUnitGroup): ?>
				<option value="<?= $groupID ?>"><?= Format::string($currentTrainUnitGroup->getName()) ?></option>
			<? endforeach; ?>
		</select>
		<input type="submit" name="group" value="Umgruppieren">
	</span>
	<span class="Right">
		<input type="submit" name="connect" value="Koppeln">
		<input type="submit" name="sell" value="Verkaufen">
	</span>
	<div class="Clear"></div>
</form>