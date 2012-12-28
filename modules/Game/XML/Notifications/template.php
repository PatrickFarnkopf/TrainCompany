<notifications>
	<? foreach(!!!newNotifications!!! as $notificationID => $currentNotification): ?>
		<element>
			<id><?= $notificationID ?></id>
			<date><?= Format::date($currentNotification->getTime(),false,false,true) ?></date>
			<title><?= Format::string($currentNotification->getTitle()) ?></title>
			<text><?= Format::string($currentNotification->getText()) ?></text>
			<plopsAdd><?= Format::number($currentNotification->getPlopsAdd()) ?></plopsAdd>
			<plopsSub><?= Format::number($currentNotification->getPlopsSub()) ?></plopsSub>
			<delayTimeInt><?= is_object($currentNotification->getDelay()) ? $currentNotification->getDelay()->getTime()->toInt() : 0 ?></delayTimeInt>
			<delayTimeString><?= is_object($currentNotification->getDelay()) ? $currentNotification->getDelay()->getTime() : '' ?></delayTimeString>
		</element>
	<? endforeach; ?>
</notifications>