<fieldset>
	<legend>Account-Übersicht</legend>
	Du bist derzeit als <em><?= Format::string(!!!currentUserName!!!) ?></em> eingeloggt.
	Im Folgenden siehst du eine Übersicht über deinen Account, um genauere Informationen zu bekommen, klicke auf die einzelnen Menüpunkte.
</fieldset>

<fieldset class="LeftBox">
	<legend><a href="<?= >>>('game_trains') ?>">Deine Fahrzeuge</a></legend>
	<ul class="NoBullet">
		<li>
			Anzahl der Zugeinheiten:
			<em><?= Format::number(!!!countTrainUnits!!!) ?></em>
		</li>
		<? if(!!!countTrainUnits!!! > 0): ?>
			<li>
				Durchschnittsalter der Züge: ca.
				<em><?= Format::number(!!!averageAgeOfTrainUnits!!!) ?>
				<? if(!!!averageAgeOfTrainUnits!!! == 1): ?>
					Jahr
				<? else: ?>
					Jahre
				<? endif; ?></em>
			</li>
			<li>
				Aktueller Gesamtwert der Züge:
				<em><img src="img/icons/money.png" alt="Plops" title="Plops"> <?= Format::number(!!!sellPriceOfTrainsUnits!!!) ?></em>
			</li>
		<? endif; ?>
	</ul>
</fieldset>

<fieldset  class="RightBox">
	<legend><a href="<?= >>>('game_tasks') ?>">Ausschreibungen</a></legend>
	<ul class="NoBullet">
		<li>
			Anzahl der Ausschreibungen:
			<em><?= Format::number(!!!countTasks!!!) ?></em>
		</li>
		<li>
			Aktive Ausschreibungen:
			<em><?= Format::number(!!!countTaskJourneys!!!) ?></em>
		</li>
	</ul>
</fieldset>

<div class="Clear"></div>