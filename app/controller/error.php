<?php

class Controller_Error extends Lib_Controller {

	public function index() {
		header("HTTP/1.1 404 Not Found");
		echo "How I got here:";
		echo "<pre>" . debug_print_backtrace() . "</pre>";
	}

}
