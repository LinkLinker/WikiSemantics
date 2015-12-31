<?php

namespace WikiSemantics;

class Parser {

	protected $content = null;
	protected $processed = false;
	protected $lines = array();
	protected $cursor = 0;
	protected $semantics = array();

	/**
	 * Constructor (doesn't do anything)
	 * 
	 */
	public function __construct() {
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

	/**
	 * Funnction to store content in class
	 * 
	 * @param string $content Content to store
	 */
	public function setContent($content) {
		$this->content = $content;
		return $this;
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

		// Dummy set semantics
		$this->semantics = $this->lines;

		return $this;

	}

}