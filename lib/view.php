<?php

/**
 * Subclass Zend_View to capture output
 */

class Lib_View extends Zend_View {

	public $buffer;

	public function render($file) {
		return $this->buffer = parent::render($file);
	}

}
