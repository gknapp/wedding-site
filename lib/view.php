<?php

/**
 * Subclass Zend_View to capture output
 */

class Lib_View extends Zend_View {

	public $buffer;

	public function render($file = null) {
		if (empty($file)) {
			$request = new Lib_Request;
			$file = $request->getControllerName() . DS . 'index.phtml';
		}
		return $this->buffer = parent::render($file);
	}

}
