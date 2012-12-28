<?php use \Core\Format; ?><fieldset id="infoStartBox" class="LeftBox">
	<legend>Beschreibung</legend>
	TrainCompany ist ein simples Browsergame.
	<p>Die Spieler haben die Möglichkeit ihre Bahnunternehmen, durch das Umsetzen von Aufgaben, die vom System generiert werden, zum Erfolg zu bringen und direkt gegen Mitspieler anzutreten oder mit ihnen zu interagieren.</p>
	<strong>Es sind bereits <?= Format::number(\Core\i::Module()->getVarCache('userCount')) ?> Spieler registriert.</strong>
</fieldset>
<fieldset id="loginBox" class="RightBox">
	<legend>Login</legend>
	<form method="post" action="<?= \Core\Module::createModuleLink('Start',array('login'=>true)) ?>">
		<label for="userName">Benutzername:</label> <input type="text" name="userName" id="userName">
		<label for="userPassword">Passwort:</label> <input type="password" name="userPassword" id="userPassword">
		<a href="<?= \Core\Module::createModuleLink('Register') ?>">Registrieren</a> <input type="submit" value="Login">
	</form>
	<div class="Clear"></div>
</fieldset>
<div class="Clear"></div>