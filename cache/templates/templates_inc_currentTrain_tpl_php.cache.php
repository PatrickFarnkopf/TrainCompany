<?php use \Core\Format; ?><table>
	<tr>
		<td>Fahrzeug:</td>
		<td><?= Format::string($vars['train']->getName()) ?></td>
	</tr>
	<tr>
		<td class="Top">Kapazität:</td>
		<td>
			<ul class="NoBullet">
				<? if(count($vars['train']->getCapacity()) > 0): ?>
					<? foreach($vars['train']->getCapacity() as $currentCapacity=>$value): ?>
						<? $currentCapacityObject = \Game\Capacity::getObjectForID($currentCapacity) ?>
						<li>
							<img src="img/icons/<?= $currentCapacityObject->getIcon() ?>" alt="<?= $currentCapacityObject->getName() ?>" title="<?= $currentCapacityObject->getName() ?>">
							<?= Format::number($value) ?>
						</li>
					<? endforeach; ?>
				<? else: ?>
					<li>keine</li>
				<? endif; ?>
			</ul>
		</td>
	</tr>
	<tr>
		<td>Zugkraft:</td>
		<td>
			<? if($vars['train']->getForce() > 0): ?>
				<?= Format::unit(Format::number($vars['train']->getForce()), 'kN') ?>
			<? else: ?>
				keine
			<? endif; ?>
		</td>
	</tr>
	<tr>
		<td>Gewicht:</td>
		<td><?= Format::unit(Format::number($vars['train']->getWeight()), 't') ?></td>
	</tr>
	<tr>
		<td>Zuglänge:</td>
		<td><?= Format::unit(Format::number($vars['train']->getLength()), 'm') ?></td>
	</tr>
	<tr>
		<td>Vmax:</td>
		<td><?= Format::unit(Format::number($vars['train']->getSpeed()), 'km/h') ?></td>
	</tr>
	<tr>
		<td>Zuverlässigkeit:</td>
		<td><?= Format::percent($vars['train']->getReliability()) ?></td>
	</tr>
	<? if($vars['train']->hasBoughtTime()): ?>
		<tr>
			<td>Alter:</td>
			<td>
				<?= Format::number($vars['train']->getAge()) ?>
				<? if($vars['train']->getAge() == 1): ?>
					Jahr
				<? else: ?>
					Jahre
				<? endif; ?>
				alt
			</td>
		</tr>
		<tr>
			<td>Verkaufswert:</td>
			<td><img src="img/icons/money.png" alt="Plops" title="Plops"> <?= Format::number($vars['train']->getSellPrice()) ?></td>
		</tr>
	<? endif; ?>
</table>