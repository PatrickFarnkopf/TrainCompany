<div class="Left">
	<fieldset class="LeftBox" style="float: none!important;">
		<legend>Cache</legend>
		<ul class="NoBullet">
			<li>Anzahl der Dateien im Cache: <em><?= Format::number(!!!cacheInfo!!!['elementCount']) ?></em></li>
			<li>Größe des Caches: <em><?= Format::size(!!!cacheInfo!!!['size']) ?></em></li>
		</ul>
		<form method="post" action="<?= >>>(NULL,array('clearCache'=>true)) ?>">
			<input type="submit" value="Cache leeren">
		</form>
	</fieldset>

	<fieldset class="LeftBox" style="float: none!important;">
		<legend>Status</legend>
		<ul class="NoBullet">
			<li>Letzter Lauf des Daemons: <?= Format::date(!!!lastDaemon!!!, true, false, true) ?></li>
		</ul>
	</fieldset>
</div>

<fieldset class="RightBox">
	<legend>Funktionen</legend>
	<ul>
		<li><a href="<?= >>>(NULL, array('plops'=>'add')) ?>">+500k Plops</a></li>
		<li><a href="<?= >>>(NULL, array('plops'=>'sub')) ?>">-500k Plops</a></li>
		<li><a href="<?= >>>(NULL, array('trainUnits'=>'unlock')) ?>">Zugeinheiten entsperren</a></li>
		<li><a href="<?= >>>(NULL, array('applications'=>'revoke')) ?>">Bewerbungen zurückziehen</a></li>
		<li><a href="<?= >>>(NULL, array('notification'=>'new')) ?>">Neue Test-Benachrichtigung</a></li>
		<li><a href="<?= >>>(NULL, array('tasks'=>'new')) ?>">Neue Test-Ausschreibungen</a></li>
		<li><a href="<?= >>>(NULL, array('tasks'=>'removeAll')) ?>">Alle Ausschreibungen löschen</a></li>
	</ul>
</fieldset>

<div class="Clear"></div>