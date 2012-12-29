<? do { ?>
+++ Exception +++
Message: <?= $exception->getMessage() ?> 
Code: <?= $exception->getCode() ?> 
File: <?= $exception->getFile() ?> (<?= $exception->getLine() ?>)

Stacktrace:
<?= $exception->getTraceAsString() ?>



<? } while($exception = $exception->getPrevious()); ?>