<?php use \Core\Format; ?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="css/main.css" type="text/css" rel="stylesheet">
		<link href="css/tooltip.css" type="text/css" rel="stylesheet">
		<link href="css/map.css" type="text/css" rel="stylesheet">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title>
			<? if(\Core\i::Module()->issetVarCache('siteTitle')): ?>
				<?= \Core\i::Module()->getVarCache('siteTitle') ?> &middot;
			<? endif; ?>
			TrainCompany
		</title>
		<script type="text/javascript">
			var notificationDeleteLink = '<?= \Core\Module::createModuleLink('Game_XML_Notifications_Remove',array('deleteID'=>''),NULL,false) ?>';
			var notificationListLink = '<?= \Core\Module::createModuleLink('Game_XML_Notifications') ?>';
			
			window.onload = function() {
				<? foreach(\Core\i::Module()->getVarCache('currentUserNotifications') as $notificationID => $currentNotification): ?>
					
					notific('<?= $notificationID ?>',
							'<?= Format::date($currentNotification->getTime(),false,false,true) ?>',
							'<?= Format::string($currentNotification->getTitle()) ?>',
							'<?= Format::string($currentNotification->getText()) ?>',
							'<?= Format::number($currentNotification->getPlopsAdd()) ?>',
							'<?= Format::number($currentNotification->getPlopsSub()) ?>',
							'<?= is_object($currentNotification->getDelay()) ? $currentNotification->getDelay()->getTime()->toInt() : 0 ?>',
							'<?= is_object($currentNotification->getDelay()) ? $currentNotification->getDelay()->getTime() : '' ?>',
							<?= $currentNotification->isSended() ? 'false' : 'true' ?>);
					<? $currentNotification->setSended(); ?>
				<? endforeach; ?>
			}
		</script>
		<script type="text/javascript" async src="js/noti.js"></script>
		<script type="text/javascript" src="js/plugin.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
	</head>
	<body>
		<div id="topBlock">
			<div id="statusBlock">
				<img src="img/icons/user.png" alt="Benutzer" title="Benutzer"> <?= Format::string(\Core\i::Module()->getVarCache('currentUserName')) ?>
				<img src="img/icons/money.png" alt="Plops" title="Plops">
				<? if(\Core\i::Module()->getVarCache('currentUserPlops') < 0): ?>
					<span class="Red">
				<? else:?>
					<span>
				<? endif; ?>
					<?= Format::number(\Core\i::Module()->getVarCache('currentUserPlops')) ?>
				</span>
				<img src="img/icons/date.png" alt="Jahreszeit und Jahr" title="Jahreszeit und Jahr"> <?= Format::string(\Core\i::Module()->getVarCache('currentDate')) ?>

				<ul id="statusBlockBig">
					<li>Nächste Jahreszeit: <?= Format::date(\Core\i::Module()->getVarCache('timeAtNextSeason')) ?></li>
					<li>E-Mail-Addresse: <?= Format::string(\Core\i::Module()->getVarCache('currentUserMail')) ?></li>
					<li><a href="<?= \Core\Module::createModuleLink('Game_Logout') ?>">Aus „TrainCompany“ ausloggen…</a></li>
				</ul>
			</div>
			<div class="Clear"></div>
		</div>
		<div id="backgroundImg"><img src="img/BackgroundRoute.svg" alt="Hintergrundbild"></div>
		<div id="logoHead">
			TrainCompany
		</div>
		<div id="naviContainer">
			<ul>
				<li><a href="<?= \Core\Module::createModuleLink('Game_Overview') ?>">Übersicht</a></li>
				<li><a href="<?= \Core\Module::createModuleLink('Game_Trains') ?>">Fahrzeuge</a></li>
				<li><a href="<?= \Core\Module::createModuleLink('Game_Tasks') ?>">Ausschreibungen</a></li>
				<li><a href="<?= \Core\Module::createModuleLink('Game_Map') ?>">Karte</a></li>
				<li><a href="<?= \Core\Module::createModuleLink('Game_Settings') ?>">Einstellungen</a></li>
				<li><a href="<?= \Core\Module::createModuleLink('Game_Logout') ?>">Logout</a></li>
			</ul>
			<div class="Clear"></div>
		</div>
		<div id="startContainer">
			<? if(\Core\i::Module()->getVarCache('showError')): ?>
				<div class="Error">
						<?= Format::string(\Core\i::Module()->getVarCache('errorString')) ?>
				</div>
			<? endif; ?>

			<? if(\Core\i::Module()->getVarCache('showSuccess')): ?>
				<div class="Success">
					<?= Format::string(\Core\i::Module()->getVarCache('successString')) ?>
				</div>
			<? endif; ?>