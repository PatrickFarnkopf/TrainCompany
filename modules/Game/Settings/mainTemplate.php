<fieldset>
	<legend>Einstellungen</legend>
	Hier können Einstellungen vorgenommen werden, um den Account zu personalisieren oder eigene Benutzerdaten anzupassen.
	Einstellungen können jederzeit wieder rückgängig gemacht werden.
</fieldset>

<div id="groupList">
	<ul>
		<? $i = 0 ?>
		<? foreach(!!!settingModules!!! as $settingLink => $settingName): ?>
			<? $i ++ ?>
			<? if($i > 1): ?>
				<li>&middot;</li>
			<? endif; ?>
			<li>
				<? if($settingLink == !!!currentModule!!!): ?>
					&raquo;<?= Format::string($settingName) ?>&laquo;
				<? else: ?>
					<a href="<?= >>>($settingLink, [],'groupList') ?>"><?= Format::string($settingName) ?></a>
				<? endif; ?>
			</li>
		<? endforeach; ?>
	</ul>
</div>