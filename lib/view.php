<?php

/**
 * Wrapper for Zend_View
 */

class Lib_View {

	public $buffer;
	protected $view;

	public function __construct($config = null) {
		$this->view = new Zend_View($config);
	}

	public function getView() {
		return $this->view;
	}

	public function render($file) {
		$this->buffer = $this->view->render($file);
		return $this->buffer;
	}

}
