<tr class="Table<?= $vars['tableRow'] ?>">	
	<td class="Top" <? if($vars['trainUnit']->getSpeedup(\Game\Train\Unit::EMPTY_WEIGHT) > 0): ?>rowspan="2"<? endif; ?>>
		<ul class="NoBullet">
			<? foreach($vars['trainUnit']->listTrains() as $trainKey=>$currentTrain): ?>
				<li>
					<? if($trainKey != 0): ?>
						<? if(isset($vars['splitUpModule']) && isset($vars['splitUpOptions'])): ?>
							<? $vars['splitUpOptions']['element'] = $trainKey ?>
							<a href="<?= cml($vars['splitUpModule'], $vars['splitUpOptions']) ?>" title="An dieser Stelle entkoppeln" class="ConnectTrains"> </a>
						<? else: ?>
							<img src="img/icons/link.png" alt="gekoppelt">
						<? endif; ?>
					<? endif; ?>
					<span>
						<?= Format::string($currentTrain->getName()) ?>
						<div class="DetailView">
							<? ^^^('currentTrain',array('train'=>$currentTrain)) ?>
						</div>
					</span>
				</li>
			<? endforeach; ?>
		</ul>
	</td>
	<td class="Center Top"><?= Format::unit(Format::number($vars['trainUnit']->getSpeed()),'km/h') ?></td>
	<td class="Center Top"><?= Format::unit(Format::number($vars['trainUnit']->getWeight(\Game\Train\Unit::EMPTY_WEIGHT)), 't') ?></td>
	<td class="Center Top"><?= Format::number($vars['trainUnit']->getLength()) ?>&thinsp;m</td>
	<td class="Center Top">
		<ul class="NoBullet">
			<? if(count($vars['trainUnit']->getCapacity()) > 0): ?>
				<? foreach($vars['trainUnit']->getCapacity() as $currentCapacity=>$value): ?>
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
	<td class="Center Top">
		<? if($vars['trainUnit']->getDrive() == \Game\Train::DIESEL_DRIVE): ?>
			diesel
		<? elseif($vars['trainUnit']->getDrive() == \Game\Train::ELECTRO_DRIVE): ?>
			elektrisch
		<? else: ?>
			kein
		<? endif; ?>	
	</td>
	<? if(isset($vars['showSalePrice']) && $vars['showSalePrice']): ?>
		<td class="Center Top">
			<img src="img/icons/money.png" alt="Plops" title="Plops"> <?= Format::number($vars['trainUnit']->getSellPrice()) ?>
		</td>
	<? endif; ?>
	<td class="Center Top" <? if($vars['trainUnit']->getSpeedup(\Game\Train\Unit::EMPTY_WEIGHT) > 0): ?>rowspan="2"<? endif; ?>>
		<? if(isset($vars['radioButton']) && $vars['radioButton']): ?>
			<input type="radio" name="trainUnit" value="<?= $vars['trainUnitID'] ?>" <? if(isset($vars['selected']) && $vars['selected']): ?>checked="checked" <? endif; ?>>
		<? else: ?>
			<input type="checkbox" class="CheckTrain" name="trainUnits[<?= $vars['trainUnitID'] ?>]">
		<? endif; ?>
	</td>
</tr>
<? if($vars['trainUnit']->getSpeedup(\Game\Train\Unit::EMPTY_WEIGHT) > 0): ?>
	<tr class="Table<?= $vars['tableRow'] ?>">	
		<td colspan="<? if(isset($vars['showSalePrice']) && $vars['showSalePrice']): ?>6<? else: ?>5<? endif;?>" class="Top">
			<ul class="NoBullet">
				<li>
					Beschleunigung (leer):
					<?= Format::unit(Format::number($vars['trainUnit']->getSpeedup(\Game\Train\Unit::EMPTY_WEIGHT),2),'m/s&sup2;') ?>
				</li>
				<li>
					Beschleunigung (voll):
					<?= Format::unit(Format::number($vars['trainUnit']->getSpeedup(\Game\Train\Unit::MAX_WEIGHT),2),'m/s&sup2;') ?>
				</li>
				<li>Zuverlässigkeit: <?= Format::percent($vars['trainUnit']->getReliability()) ?></li>
				<? if($vars['trainUnit']->isLocked()): ?>
					<li><strong>Diese Zugeinheit ist gesperrt, da sie derzeit für eine Ausschreibung eingeplant ist.</strong></li>
				<? endif; ?>
			</ul>
		</td>
	</tr>
<? endif; ?>