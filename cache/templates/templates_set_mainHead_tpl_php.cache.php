<?php use \Core\Format; ?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="css/main.css" type="text/css" rel="stylesheet">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title>
			<? if(\Core\i::Module()->issetVarCache('siteTitle')): ?>
				<?= \Core\i::Module()->getVarCache('siteTitle') ?> &middot;
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
			<? if(\Core\i::Module()->issetVarCache('showError') && \Core\i::Module()->getVarCache('showError')): ?>
				<div class="Error">
						<?= Format::string(\Core\i::Module()->getVarCache('errorString')) ?>
				</div>
			<? endif; ?>

			<? if(\Core\i::Module()->issetVarCache('showSuccess') && \Core\i::Module()->getVarCache('showSuccess')): ?>
				<div class="Success">
					<?= Format::string(\Core\i::Module()->getVarCache('successString')) ?>
				</div>
			<? endif; ?>
			
			<? if(\Core\i::Module()->getVarCache('currentModule') != 'Start' && \Core\i::Module()->getVarCache('currentModule') != 'Install'): ?>
				<a href="<?= \Core\Module::createModuleLink('Start') ?>">&laquo; Zurück zur Startseite</a>
				<div class="Clear"></div>
			<? endif; ?>