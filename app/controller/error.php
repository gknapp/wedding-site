<?php

class Controller_Error extends Lib_Controller {

	public function index() {
		header("HTTP/1.1 404 Not Found");
		$this->_layout->setLayout('error');
		$this->view->render('error' . DS . 'index.phtml');
		/*
		ob_start();
		debug_print_backtrace();
		$trace = ob_get_clean();
		echo "<pre>" . nl2br($trace) . "</pre>";
		*/
	}

	public function error($num, $msg, $file, $line) {
		header("HTTP/1.1 500 Internal Server Error");
		echo sprintf("<p>%s in %s on line %s</p>", $msg, $file, $line);
	}

	public function exception($e) {
		header("HTTP/1.1 500 Internal Server Error");
		echo sprintf(
			"<p>Exception:<br/>%s<br/>in %s on line %s</p>",
			$e->getMessage(), $e->getFile(), $e->getLine()
		);
	}

}
