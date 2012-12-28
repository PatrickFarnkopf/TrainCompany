<?php use \Core\Format; ?><strong>Strecken-Informationen</strong>
<ul class="NoBullet">
	<li>Länge: <?= Format::unit(Format::number($vars['path']->getLength()), 'km') ?></li>
	<li>Vmax: <?= Format::unit(Format::number($vars['path']->getMaxSpeed()), 'km/h') ?></li>
	<li>
		<? if($vars['path']->isEletrified()): ?>
			elektrifiziert
		<? else: ?>
			<strong>nicht</strong> elektrifiziert
		<? endif; ?>
	</li>
</ul>
<em>(Zum Schließen des Fenster, klicken.)</em>