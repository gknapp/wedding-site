<?php

class Dispatcher {

	const DEFAULT_METHOD = 'index';

	public function run() {
		$request = $this->getRequest();
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		var_dump($action);
	}

	public function getRequest() {
		return new Request;
	}

}
