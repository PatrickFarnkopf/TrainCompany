<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="css/main.css" type="text/css" rel="stylesheet">
		<link href="css/tooltip.css" type="text/css" rel="stylesheet">
		<link href="css/map.css" type="text/css" rel="stylesheet">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title>
			<? if(???siteTitle???): ?>
				<?= !!!siteTitle!!! ?> &middot;
			<? endif; ?>
			TrainCompany
		</title>
		<script type="text/javascript">
			var notificationDeleteLink = '<?= >>>('Game_XML_Notifications_Remove',['deleteID'=>''],NULL,false) ?>';
			var notificationListLink = '<?= >>>('Game_XML_Notifications') ?>';
			
			window.onload = function() {
				<? foreach(!!!currentUserNotifications!!! as $notificationID => $currentNotification): ?>
					
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
				<img src="img/icons/user.png" alt="Benutzer" title="Benutzer"> <?= Format::string(!!!currentUserName!!!) ?>
				<img src="img/icons/money.png" alt="Plops" title="Plops">
				<? if(!!!currentUserPlops!!! < 0): ?>
					<span class="Red">
				<? else:?>
					<span>
				<? endif; ?>
					<?= Format::number(!!!currentUserPlops!!!) ?>
				</span>
				<img src="img/icons/date.png" alt="Jahreszeit und Jahr" title="Jahreszeit und Jahr"> <?= Format::string(!!!currentDate!!!) ?>

				<ul id="statusBlockBig">
					<li>Nächste Jahreszeit: <?= Format::date(!!!timeAtNextSeason!!!) ?></li>
					<li>E-Mail-Addresse: <?= Format::string(!!!currentUserMail!!!) ?></li>
					<li><a href="<?= >>>('Game_Logout') ?>"><img src="img/icons/door_out.png" alt="Logout"> Aus „TrainCompany“ ausloggen…</a></li>
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
				<li><a href="<?= >>>('Game_Overview') ?>">Übersicht</a></li>
				<li><a href="<?= >>>('Game_Trains') ?>">Fahrzeuge</a></li>
				<li><a href="<?= >>>('Game_Tasks') ?>">Ausschreibungen</a></li>
				<li><a href="<?= >>>('Game_Map') ?>">Karte</a></li>
				<li><a href="<?= >>>('Game_Settings') ?>">Einstellungen</a></li>
				<li><a href="<?= >>>('Game_Logout') ?>">Logout</a></li>
			</ul>
			<div class="Clear"></div>
		</div>
		<div id="startContainer">
			<? if(!!!showError!!!): ?>
				<div class="Error">
						<?= Format::string(!!!errorString!!!) ?>
				</div>
			<? endif; ?>

			<? if(!!!showSuccess!!!): ?>
				<div class="Success">
					<?= Format::string(!!!successString!!!) ?>
				</div>
			<? endif; ?>