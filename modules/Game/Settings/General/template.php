<fieldset class="RightBox">
	<legend>Passwort ändern</legend>
	<form method="post" action="<?= >>>(NULL, array('changePass'=>true)) ?>">
		<label for="userPass">Neues Passwort:</label>
		<input type="password" id="userPass" name="userPass" value="<?= Format::string(!!!userPass!!!) ?>">
		
		<label for="userPassAgain">Passwort wiederholen:</label>
		<input type="password" id="userPassAgain" name="userPassAgain" value="<?= Format::string(!!!userPassAgain!!!) ?>">
		
		<div class="Clear"></div>
		<input type="submit" value="Passwort ändern">
	</form>
</fieldset>

<fieldset class="LeftBox">
	<legend>E-Mail-Adresse ändern</legend>
	<form method="post" action="<?= >>>(NULL, array('changeMail'=>true)) ?>">
		<label for="userMail">Neue E-Mail-Adresse:</label>
		<input type="email" id="userMail" name="userMail" placeholder="<?= Format::string(!!!currentUserMail!!!) ?>" value="<?= Format::string(!!!userMail!!!) ?>">
		
		<div class="Clear"></div>
		<input type="submit" value="E-Mail-Adresse ändern">
	</form>
</fieldset>

<div class="Clear"></div>