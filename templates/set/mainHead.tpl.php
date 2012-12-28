<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="css/main.css" type="text/css" rel="stylesheet">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title>
			<? if(???siteTitle???): ?>
				<?= !!!siteTitle!!! ?> &middot;
			<? endif; ?>
			TrainCompany
		</title>
	</head>
	<body>
		<div id="backgroundImg"><img src="img/BackgroundRoute.svg" alt="Hintergrundbild"></div>
		<div id="logoHead">
			TrainCompany
		</div>
		<div id="startContainer">
			<? if(???showError??? && !!!showError!!!): ?>
				<div class="Error">
						<?= Format::string(!!!errorString!!!) ?>
				</div>
			<? endif; ?>

			<? if(???showSuccess??? && !!!showSuccess!!!): ?>
				<div class="Success">
					<?= Format::string(!!!successString!!!) ?>
				</div>
			<? endif; ?>
			
			<? if(!!!currentModule!!! != 'Start' && !!!currentModule!!! != 'Install'): ?>
				<a href="<?= >>>('Start') ?>">&laquo; Zurück zur Startseite</a>
				<div class="Clear"></div>
			<? endif; ?>