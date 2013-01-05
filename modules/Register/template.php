<fieldset id="infoRegisterBox" class="RightBox">
	<legend>Erklärung</legend>
	Damit du im Mulitplayer mit anderen Spielern zusammen spielen kannst, musst du dir zuerst ein Account anlegen.
</fieldset>
	
<fieldset id="registerBox" class="LeftBox">
	<legend>Registrierung</legend>
	<form method="post" action="<?= >>>(NULL, ['register'=>'true']) ?>">
		<label for="userName">Benutzername:</label>
		<input type="text" name="userName" id="userName" value="<?= Format::string(!!!userName!!!) ?>">
			
		<label for="userMail">E-Mail-Adresse:</label>
		<input type="email" name="userMail" id="userMail" value="<?= Format::string(!!!userMail!!!) ?>">
			
		<label for="userPassword">Passwort:</label>
		<input type="password" name="userPassword" id="userPassword" value="<?= Format::string(!!!userPassword!!!) ?>">
			
		<label for="userPasswordAgain">Passwort wiederholen:</label>
		<input type="password" name="userPasswordAgain" id="userPasswordAgain" value="<?= Format::string(!!!userPasswordAgain!!!) ?>">
		<div class="Clear"></div>
			
		<input type="submit" value="Registrieren">
	</form>
</fieldset>
<div class="Clear"></div>