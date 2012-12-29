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
		<h2>Installation konnte nicht gestartet werden</h2>
		<p>Damit die Installation erfolgreich gestartet werden kann, müssen einige Bedingungen erfüllt sein.  Bitte erfülle alle folgenden Punkte:</p>
		<ul>
			<li>Mindestens <strong>PHP <?= \Core\Install::REQUIERED_PHP_VERSION ?>.</strong></li>
			<li>Das „<?= \Core\CacheFile::DIR ?>“-Verzeichnis muss existieren und beschreibbar sein.</li>
		</ul>
		<h5>Folgender Fehler ist aufgetreten:</h5>
		<textarea rows="15" cols="90"><? include(ROOT_PATH.'templates/ExceptionPlain.tpl.php') ?></textarea>
	</body>
</html>