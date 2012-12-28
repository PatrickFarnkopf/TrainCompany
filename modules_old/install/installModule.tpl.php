<? if(!defined('INC')) exit; ?>
<? if(cmi()->getVarCache('showError')): ?>
<div class="Error">
	<?= Format::string(cmi()->getVarCache('errorString')) ?>
</div>
<? endif; ?>


<fieldset>
	<legend>Installations-Beschreibung</legend>
	Um &bdquo;TrainCompany&ldquo; erfolgreich zu installieren müssen die folgenden Einstellungen vorgenommen werden.
	Bevor Daten eingegeben werden können, müssen zuerst alle Vorraussetzungen erfüllt werden.
</fieldset>

<form method="post" action="<?= cml('install', array('writeConfiguration'=>true)) ?>">
	<fieldset class="RightBox">
		<legend>MySQL-Daten</legend>
		<label for="mysqlServer">Servername:</label>
		<input type="text" name="mysqlServer" id="mysqlServer" <? if(cmi()->getVarCache('badStatus')):?> disabled="disabled" <? endif; ?>  value="<?= Format::string(cmi()->getVarCache('mysqlServer')) ?>">
		
		<label for="mysqlUser">Benutzer:</label>
		<input type="text" name="mysqlUser" id="mysqlUser" <? if(cmi()->getVarCache('badStatus')):?> disabled="disabled" <? endif; ?>  value="<?= Format::string(cmi()->getVarCache('mysqlUser')) ?>">
		
		<label for="mysqlPass">Passwort:</label>
		<input type="password" name="mysqlPass" id="mysqlPass" <? if(cmi()->getVarCache('badStatus')):?> disabled="disabled" <? endif; ?>  value="<?= Format::string(cmi()->getVarCache('mysqlPass')) ?>">
		
		<label for="mysqlDatabase">Datenbank-Name:</label>
		<input type="text" name="mysqlDatabase" id="mysqlDatabase" <? if(cmi()->getVarCache('badStatus')):?> disabled="disabled" <? endif; ?>  value="<?= Format::string(cmi()->getVarCache('mysqlDatabase')) ?>">
		
		<label for="createDatabase">Datenbank erstellen?</label>
		<input type="checkbox" name="createDatabase" id="createDatabase" <? if(cmi()->getVarCache('badStatus')):?> disabled="disabled" <? endif; ?>  <? if(cmi()->getVarCache('createDatabase')): ?> checked="checked"<? endif; ?>>
	</fieldset>

	<fieldset class="LeftBox">
		<legend>Status</legend>
		<? if(cmi()->getVarCache('badStatus')):?> <span style="color: red;"> <? endif; ?>
			<?= cmi()->getVarCache('statusString') ?>
		<? if(cmi()->getVarCache('badStatus')):?> 
			</span>
		<? endif; ?>
	</fieldset>

	<fieldset class="LeftBox">
		<legend>Allgemeine Einstellungen</legend>
		<label for="currentTimeZone">Aktuelle Zeitzone:</label>
		<select name="currentTimeZone" id="timeZone" <? if(cmi()->getVarCache('badStatus')):?> disabled="disabled" <? endif; ?>>
			<? foreach (cmi()->getVarCache('knownTimeZones') as $key=>$string): ?>
				<option value="<?= $key ?>" <? if($key == cmi()->getVarCache('currentTimeZone')): ?>selected="selected"<? endif; ?>><?= Format::string($string) ?></option>
			<? endforeach; ?>
		</select>
		
		<label for="debugMode">Debug-Modus?</label>
		<input type="checkbox" name="debugMode" id="debugMode" <? if(cmi()->getVarCache('badStatus')):?> disabled="disabled" <? endif; ?>  <? if(cmi()->getVarCache('debugMode')): ?> checked="checked"<? endif; ?>>
	</fieldset>

	<div class="Clear"></div>
	<input type="submit" class="Right" value="Installation durchführen" <? if(cmi()->getVarCache('badStatus')):?> disabled="disabled" <? endif; ?>>
	<div class="Clear"></div>
</form>