<?php use \Core\Format; ?><fieldset class="LeftBox">
	<legend><?= Format::string($vars['task']->getTitle()) ?></legend>
	<?= Format::string($vars['task']->getDescription()) ?>
	<hr>
	<span class="Left">
		<img src="img/icons/money_add.png" alt="Plops" title="Plops">
		<?= Format::number($vars['task']->getPlops()) ?>
	</span>
	<span class="Right">
		Benötigte Kapazitäten:
		<? foreach($vars['task']->getNeededCapacity() as $currentCapacity=>$value): ?>
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
	</span>
	<div class="Clear"></div>			
</fieldset>