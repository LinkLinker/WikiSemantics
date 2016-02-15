<?php

include __DIR__ . '/../vendor/autoload.php';

use MongoDB\MongoDB;
phpinfo();
$baseDir = __DIR__ . '/../';

try {

    $mongoClient = new \MongoDB\Client(
        'mongodb://localhost',
        ['readPreference' => 'secondaryPreferred']
    );


    echo "end";
    die();
	$term = "Luc Nilis";

	$sParser = new WikiSemantics\SparqlParser($term);
	$sParser
		->read($baseDir . "/tmp/wiki/" . $term . ".sparql");

    var_dump($sParser->getContent());

	$teams   = $sParser->get("http://dbpedia.org/ontology/team");
	$related = $sParser->map("http://dbpedia.org/ontology/team", "http://dbpedia.org/property/caps");

	echo "\n\n";
	var_dump($teams);
	var_dump($related);

	//var_dump($content);
} catch (Exception $e) {
	echo 'Caught exception: ', $e->getMessage(), "\n";
}
