<?php

namespace WikiSemantics;

//use GuzzleHttp\Psr7\Request

class SparqlParser extends Parser {

	protected $content  = null;
	protected $semantic = array();
	protected $term     = null;

	/**
	 * Constructor (doesn't do anything)
	 *
	 */
	public function __construct($term) {
		$this->term = str_replace(" ", "_", $term);
	}

	public function read($file) {
		$this->content  = file_get_contents($file);
		$this->semantic = json_decode($this->content, true);
		return $this;
	}

	public function get($ontClass) {
		$rv = array();

		if (isset($this->semantic["http://dbpedia.org/resource/" . $this->term][$ontClass])) {
			$classes = $this->semantic["http://dbpedia.org/resource/" . $this->term][$ontClass];

			foreach ($classes as $c) {
				$rv[] = $c['value'];
			}
		}

		return $rv;
	}

	public function map($ontClassOne, $ontClassTwo) {
		$ontClassOneData = $this->get($ontClassOne);
		$ontClassTwoData = $this->get($ontClassTwo);

		if (count($ontClassOneData) == count($ontClassTwoData)) {
			$ontCombined = array_combine($ontClassOneData, $ontClassTwoData);
			return $ontCombined;
		}
		return array();
	}

}