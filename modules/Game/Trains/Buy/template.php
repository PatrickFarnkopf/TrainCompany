<a href="<?= >>>('Game_Trains') ?>">&laquo; Zurück zu deinen Fahrzeugen</a>

<fieldset>
	<legend>Neue Fahrzeuge kaufen</legend>
	Hier hast du einen Überblick über Fahrzeug, die zum Verkauf stehen.
	Du siehst allgemeine Technische-Daten, den Preis und wie viele du bereits von dieser Baureihe hast.
	Die Liste ist untergliedert in &bdquo;Triebzüge&ldquo;, &bdquo;Lokomotiven&ldquo; und &bdquo;Wagons&ldquo;.
</fieldset>

<div id="groupList">
	<ul>
		<? $i = 0 ?>
		<? foreach(!!!trainTypes!!! as $trainType => $typeName): ?>
			<? $i ++ ?>
			<? if($i > 1): ?>
				<li>&middot;</li>
			<? endif; ?>
			<li>
				<? if(!!!trainType!!! == $trainType): ?>
					&raquo;<?= Format::string($typeName) ?>&laquo;
				<? else: ?>
					<a href="<?= >>>(NULL, array('trainType'=>$trainType),'groupList') ?>"><?= Format::string($typeName) ?></a>
				<? endif; ?>
			</li>
		<? endforeach; ?>
	</ul>
</div>

<form method="post" action="<?= >>>(NULL,array('trainType'=>!!!trainType!!!,'buyTrains'=>true)) ?>">
	<table class="OverviewTable">
		<tr>
			<th width="180" >Fahrzeug</th>
			<th>Vmax</th>
			<th>Zugkraft</th>
			<th>Kapazität</th>
			<th>Antrieb</th>
			<th>Kosten</th>
			<th>Anzahl</th>
		</tr>
		<? foreach(!!!trainList!!! as $key=>$currentTrain): ?>
		<tr class="Table<?= $key%2 ?>">
			<td>
				<span>
					<?= Format::string($currentTrain->getName()) ?>
					<div class="DetailView">
						<? ^^^('currentTrain',array('train'=>$currentTrain)) ?>
					</div>
				</span>
			</td>
			<td class="Center"><?= Format::unit(Format::number($currentTrain->getSpeed()),'km/h') ?></td>
			<td class="Center">
				<? if($currentTrain->getForce() > 0): ?>
					<?= Format::unit(Format::number($currentTrain->getForce()),'kN') ?>
				<? else: ?>
					keine
				<? endif; ?>
			</td>
			<td class="Center">
				<ul class="NoBullet">
					<? if(count($currentTrain->getCapacity()) > 0): ?>
						<? foreach($currentTrain->getCapacity() as $currentCapacity=>$value): ?>
							<? $currentCapacityObject = \Game\Capacity::getObjectForID($currentCapacity) ?>
							<li>
								<img src="img/icons/<?= $currentCapacityObject->getIcon() ?>" alt="<?= $currentCapacityObject->getName() ?>" title="<?= $currentCapacityObject->getName() ?>">
								<? $unit = $currentCapacityObject->getUnit() ?>
								<? if(!empty($unit)): ?>
									<?= Format::unit(Format::number($value),$unit) ?>
								<? else: ?>
									<?= Format::number($value) ?>
								<? endif; ?>
							</li>
						<? endforeach; ?>
					<? else: ?>
						<li>keine</li>
					<? endif; ?>
				</ul>
			</td>
			<td class="Center">
				<? if($currentTrain->getDrive() == \Game\Train::DIESEL_DRIVE): ?>
					diesel
				<? elseif($currentTrain->getDrive() == \Game\Train::ELECTRO_DRIVE): ?>
					elektrisch
				<? else: ?>
					kein
				<? endif; ?>	
			</td>
			<td class="Center"><img src="img/icons/money.png" alt="Plops" title="Plops"> <?= Format::number($currentTrain->getCost()) ?></td>
			<td class="Center"><?= Format::number(!!!currentUserInstance!!!->searchTrain($currentTrain)) ?>+<input type="text" size="2" placeholder="0" name="trains[<?= $currentTrain->getID() ?>]"></td>
		</tr>
		<? endforeach; ?>
	</table>
	
	<input class="Right" type="submit" value="Fahrzeuge kaufen">
	<div class="Clear"></div>
</form>