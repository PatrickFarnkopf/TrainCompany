<h3><?= Format::string($vars['station']->getName()) ?></h3>
<ul>
	<? if($vars['station']->getPlatforms() == 0): ?>
		<li>Betriebsbahnhof</li>
	<? else: ?>
		<li>Bahnsteige: <?= Format::number($vars['station']->getPlatforms()) ?></li>
		<li>Bahnsteigslänge: <?= Format::unit(Format::number($vars['station']->getPlatformLength()), 'm') ?></li>
	<? endif; ?>
	<? if(\Config\DEBUG): ?>
		<li>Bahnhofs-ID: <?= Format::number($vars['station']->getID()) ?></li>
	<? endif; ?>
</ul>