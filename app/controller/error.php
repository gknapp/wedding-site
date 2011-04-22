<?php

class Controller_Error extends Lib_Controller {

	public function index() {
		echo "How I got here:";

		$trace = array_reverse(debug_backtrace());
		$buffer = '';
		foreach ($trace as $step) {
			if (isset($step['class']))
				$buffer .= $step['class'];

			if (isset($step['type']))
				$buffer .= $step['type'];

			$buffer .= $step['function'] . "(" . implode(', ', $step['args']) . ")\n";
		}
		echo "<pre>" . $buffer . "</pre>";
	}

}
