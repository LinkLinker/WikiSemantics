<?php

include __DIR__.'/../vendor/autoload.php';

try {
	$parser = new WikiSemantics\Parser();
	$content = $parser->file(__DIR__."/afcajax.wiki")->getSemantics();

	var_dump($content);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
