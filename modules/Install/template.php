<fieldset>
	<legend>Installations-Beschreibung</legend>
	Um &bdquo;TrainCompany&ldquo; erfolgreich zu installieren müssen die folgenden Einstellungen vorgenommen werden.
	Bevor Daten eingegeben werden können, müssen zuerst alle Vorraussetzungen erfüllt werden.
</fieldset>

<form method="post" action="<?= >>>(NULL, ['writeConfiguration'=>true]) ?>">
	<fieldset class="RightBox">
		<legend>MySQL-Daten</legend>
		<label for="mysqlServer">Servername:</label>
		<input type="text" name="mysqlServer" id="mysqlServer" <? if(!!!badStatus!!!):?> disabled="disabled" <? endif; ?>  value="<?= Format::string(!!!mysqlServer!!!) ?>">
		
		<label for="mysqlUser">Benutzer:</label>
		<input type="text" name="mysqlUser" id="mysqlUser" <? if(!!!badStatus!!!):?> disabled="disabled" <? endif; ?>  value="<?= Format::string(!!!mysqlUser!!!) ?>">
		
		<label for="mysqlPass">Passwort:</label>
		<input type="password" name="mysqlPass" id="mysqlPass" <? if(!!!badStatus!!!):?> disabled="disabled" <? endif; ?>  value="<?= Format::string(!!!mysqlPass!!!) ?>">
		
		<label for="mysqlDatabase">Datenbank-Name:</label>
		<input type="text" name="mysqlDatabase" id="mysqlDatabase" <? if(!!!badStatus!!!):?> disabled="disabled" <? endif; ?>  value="<?= Format::string(!!!mysqlDatabase!!!) ?>">
		
		<label for="createDatabase">Datenbank erstellen?</label>
		<input type="checkbox" name="createDatabase" id="createDatabase" <? if(!!!badStatus!!!):?> disabled="disabled" <? endif; ?>  <? if(!!!createDatabase!!!): ?> checked="checked"<? endif; ?>>
	</fieldset>

	<fieldset class="LeftBox">
		<legend>Status</legend>
		<? if(!!!badStatus!!!):?> <span style="color: red;"> <? endif; ?>
			<?= !!!statusString!!! ?>
		<? if(!!!badStatus!!!):?> 
			</span>
		<? endif; ?>
	</fieldset>

	<fieldset class="LeftBox">
		<legend>Allgemeine Einstellungen</legend>
		<label for="currentTimeZone">Aktuelle Zeitzone:</label>
		<select name="currentTimeZone" id="timeZone" <? if(!!!badStatus!!!):?> disabled="disabled" <? endif; ?>>
			<? foreach (!!!knownTimeZones!!! as $key=>$string): ?>
				<option value="<?= $key ?>" <? if($key == !!!currentTimeZone!!!): ?>selected="selected"<? endif; ?>><?= Format::string($string) ?></option>
			<? endforeach; ?>
		</select>
		
		<label for="debugMode">Debug-Modus?</label>
		<input type="checkbox" name="debugMode" id="debugMode" <? if(!!!badStatus!!!):?> disabled="disabled" <? endif; ?>  <? if(!!!debugMode!!!): ?> checked="checked"<? endif; ?>>
	</fieldset>

	<div class="Clear"></div>
	<input type="submit" class="Right" value="Installation durchführen" <? if(!!!badStatus!!!):?> disabled="disabled" <? endif; ?>>
	<div class="Clear"></div>
</form>