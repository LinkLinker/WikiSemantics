<?php

namespace WikiSemantics;

use GuzzleHttp\Client as Client;

//use GuzzleHttp\Psr7\Request

class Crawler {

	protected $content   = null;
	protected $processed = false;
	protected $lines     = array();
	protected $cursor    = 0;
	protected $semantics = array();
	protected $client;
	protected $dbpedia;

	/**
	 * Constructor (doesn't do anything)
	 *
	 */
	public function __construct() {
		$this->client = new \GuzzleHttp\Client(array(
			"base_uri" => "https://en.wikipedia.org",
		));
		$this->dbpedia = new \GuzzleHttp\Client(array(
			"base_uri" => "http://dbpedia.org",
		));
	}

	/**
	 * Local file to read
	 *
	 * @param  string $file [description]
	 * @return \WikiSemantic\Parser 	Return this for chaining
	 */
	public function file($file) {
		if (!file_exists($file)) {
			throw new Exception("File not found");
		}
		$content = file_get_contents($file);
		if (empty($content)) {
			throw new Exception("No content");
		}
		$this->content = $content;
		return $this;
	}

	/**
	 * Returns the stored contnet
	 * @return string Content of readed resource
	 */
	public function getContent() {
		return $this->content;
	}

	public function api($title, $lang = "en") {
		global $baseDir;

		$url = "/w/api.php?action=query&prop=revisions&rvprop=content&rvsection=0&titles=" . $title . "&format=json";
		if ($lang != "en") {
			$url = "https://" . $lang . ".wikipedia.org" . $url;
		}

		echo "\n\n ==== API == " . $url . " ==== \n\n";

		$response = $this->client->request('GET', $url);
		$content  = (string) $response->getBody();

		$json = json_decode($content, true);

		try {
			$pages = $json['query']['pages'];
			foreach ($pages as $pageId => $page) {
				if ($pageId < 0) {
					echo "Page not found (lang " . $lang . ")";
				} else {
					$revision = array_shift($page['revisions']);
					$wikitext = $revision["*"];

					file_put_contents($baseDir . "/tmp/wiki/" . $page['pageid'] . "" . $lang . ".wiki", $wikitext);
					echo "Wiki content stored (lang " . $lang . ")";
				}
			}

		} catch (Exception $e) {
			echo "No content";
		}

		return $this;
	}

	public function sparql($title) {
		global $baseDir;
		$url = "/data/" . str_replace(" ", "_", $title) . ".json";

		echo "\n\n ==== SPARQL == " . $url . " ==== \n\n";

		$response = $this->dbpedia->request('GET', $url);
		$content  = (string) $response->getBody();
		$json     = json_decode($content, true);

		file_put_contents($baseDir . "/tmp/wiki/" . $title . ".sparql", $content);

		echo "Found " . count($json) . " semantic entries";

		return $this;
	}

}