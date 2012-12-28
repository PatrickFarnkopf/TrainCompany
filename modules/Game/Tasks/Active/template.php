<fieldset>
	<legend>Aktive Ausschreibungen</legend>
	Hier siehst du genau, wie weit du mit einzelnen Ausschreibungen bist. Dir wird die vorrausichtliche Ankunft und Verspätung deiner Züge und alle Verspätungen angezeigt. Außerdem siehst du, wie viel die Ausschreibung dir nach Abschluss an Plops bringt und wie viel du durch die Verspätungen verlierst.
</fieldset>

<div id="groupList">
	<ul>
		<li><a href="<?= >>>('Game_Tasks', array(), 'groupList') ?>">Neue Ausschreibungen</a></li>
		<li>&middot;</li>
		<li>&raquo;Aktive Ausschreibungen&laquo;</li>
	</ul>
</div>

<? if(count(!!!taskJourneyList!!!) == 0): ?>
	<p class="Center">
		Derzeit existieren keine aktiven Ausschreibungen.
	</p>
<? else: ?>
	<? foreach(!!!taskJourneyList!!! as $currentTaskJourney): ?>
		<div class="TaskJourney">
			<div class="TaskInfo">
				<strong><?= Format::string($currentTaskJourney->getTask()->getTitle()) ?></strong>
				<p><?= Format::string($currentTaskJourney->getTask()->getDescription()) ?></p>
				<span class="Left">
					<img src="img/icons/money_add.png" alt="Plops" title="Plops dazu">
					<span class="Green"><?= Format::number($currentTaskJourney->getTask()->getPlops()) ?></span>
				</span>
				<span class="Right">
					<img src="img/icons/money_delete.png" alt="Plops" title="Plops ab">
					<span class="Red"><?= Format::number($currentTaskJourney->getDelaySub()) ?></span>
				</span>
				<div class="Clear"></div>	
				
				<ul class="NoBullet">
					<li>
						<img src="img/icons/basket_put.png" alt="Kapazität" title="Kapazität"> Kapazität genutzt:
						<? if(count($currentTaskJourney->getTrainUnit()->getUsedCapacity()) == 0): ?>
							keine
						<? endif; ?>
						<? foreach($currentTaskJourney->getTrainUnit()->getUsedCapacity() as $currentCapacity=>$value): ?>
							<? $currentCapacityObject = \Game\Capacity::getObjectForID($currentCapacity) ?>
							<img src="img/icons/<?= $currentCapacityObject->getIcon() ?>" alt="<?= $currentCapacityObject->getName() ?>" title="<?= $currentCapacityObject->getName() ?>">
							<? if($value>0): ?>
								<? $unit = $currentCapacityObject->getUnit() ?>
								<? if(!empty($unit)): ?>
									<?= Format::unit(Format::number($value),$unit) ?>
								<? else: ?>
									<?= Format::number($value) ?>
								<? endif; ?>
							<? else: ?>
								?
							<? endif; ?>
						<? endforeach; ?>
					</li>
					<li>
						<img src="img/icons/clock_go.png" alt="Ankunfzeit" title="Ankunfzeit bei aktueller Verspätung">
						vsl. <?= Format::date($currentTaskJourney->getTimeAtEnd(),false,true,true) ?>
						(<?= ^^^('delay', array('delayTime'=>$currentTaskJourney->getCurrentDelay())) ?>)
					</li>
				</ul>
			</div>
			
			<div class="JourneyInfo">
				<ul class="NoBullet">
					<li>
						<img src="img/icons/map_go.png" alt="Position" title="Aktuelle Position">
						Zwischen <strong><?= Format::string($currentTaskJourney->getCurrentStation()->getName()) ?></strong>
						und <strong><?= Format::string($currentTaskJourney->getNextStation()->getName()) ?></strong>.
					</li>
					<li>
						<img src="img/icons/clock_go.png" alt="Restzeit" title="Restzeit auf diesem Strecken-Abschnitt">
						<?= Format::date($currentTaskJourney->getNextStepTime(),false,true,true) ?>
					</li>
					<li>
						<img src="img/icons/clock_red_stop.png" alt="Verspätungen" title="Alle Verspätungen"> Verspätungen:
						<ul>
							<? if(count($currentTaskJourney->getDelays())): ?>
								<? foreach($currentTaskJourney->getDelays() as $currentDelay): ?>
									<li>
										<?= ^^^('delay', array('delayTime'=>$currentDelay->getTime())) ?>:
										„<?= Format::string($currentDelay->getDescription()) ?>“
									</li>
								<? endforeach; ?>
							
							<? else: ?>
								<li>Keine</li>
							<? endif; ?>
						</ul>
					</li>
				</ul>
			</div>
			<div class="Clear"></div>
		</div>
	<? endforeach; ?>
<? endif; ?>