<?php

namespace WikiSemantics;

//use GuzzleHttp\Psr7\Request

class WikiTextParser extends Parser {

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
	public function __construct($file = false) {
        if (!empty($file)) {
            $this->file($file);
        }
        return $this;
	}

    public function file($file) {
        $content = file_get_contents($file);
        return $this->setContent($content);
    }

    protected static function startWith($line, $prefix) {
        $line = trim($line);
        return (substr($line, 0, strlen($prefix)) == $prefix);
    }

    protected static function endWith($line, $postfix) {
        $line = trim($line);
        return (substr($line, 0, strlen($prefix)) == $prefix);
    }

	public function getSemantics() {
		if (!$this->processed) {
			$this->process();
		}
		return $this->semantics;
	}

	protected function process() {
		$content = $this->getContent();

		// Fetch lines (remove empty lines)
		$this->lines  = array_filter(explode(PHP_EOL, $content));
		$this->cursor = 0;

		foreach ($this->lines as $line) {

			if (self::startWith($line, "==")) {

				//echo $line."\n";

			} else if (self::startWith($line, "{{")) {
				echo "A=" . " " . $line . "\n";
			}

		}

		// Dummy set semantics
		$this->semantics = $this->lines;

		return $this;

	}

}