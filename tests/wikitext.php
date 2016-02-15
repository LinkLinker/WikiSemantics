<?php

include __DIR__ . '/../vendor/autoload.php';

$baseDir = __DIR__ . '/../';

try {
	$file = $baseDir."/tmp/wiki/2273en.wiki";

	$sParser = new WikiSemantics\WikiTextParser($file);
	$sem = $sParser->getSemantics();
		
    var_dump($sem);

	
} catch (Exception $e) {
	echo 'Caught exception: ', $e->getMessage(), "\n";
}
