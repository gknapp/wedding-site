<?php

class Controller_Error extends Lib_Controller {

	public function index() {
		header("HTTP/1.1 404 Not Found");
		echo "How I got here:";
		ob_start();
		debug_print_backtrace();
		$trace = ob_get_clean();
		echo "<pre>" . nl2br($trace) . "</pre>";
	}

}
