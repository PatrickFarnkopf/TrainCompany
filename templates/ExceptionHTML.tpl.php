<!DOCTYPE html>
<html>
	<head>
		<title>Fehler</title>
		<style type="text/css">
			body {
				font-family: "PT Sans", "Helvetica", Sans-Serif;
				}
		</style>
		<meta charset="UTF-8">
	</head>
	<body>
		<? do { ?>
			<h2>Huch, da ist uns ein Fehler passiert :(</h2>
			<p>
				Das Skript hat eine Exception geworfen, wir konnten sie noch auffangen, mussten das Skript aber beenden.
				<em>
					<?= htmlspecialchars(get_class($exception)) ?>
				</em>
			</p>
			<p>
				<em><?= htmlspecialchars($exception->getMessage()) ?></em> <strong>Nummer:</strong> <?= $exception->getCode() ?>
			</p>
			<? if(\Config\DEBUG): ?>
				<p>
					<strong>Zeile:</strong> <?= $exception->getLine() ?>
					<strong>Datei:</strong> <?= htmlspecialchars($exception->getFile()) ?> 
				</p>
				<p>Stacktrace:</p>
				<textarea rows="12" cols="100"><?= htmlspecialchars($exception->getTraceAsString()) ?></textarea>
			<? endif; ?>
		<? } while($exception = $exception->getPrevious()); ?>
	</body>
</html>