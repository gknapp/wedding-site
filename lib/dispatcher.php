<?php

class Lib_Dispatcher {

	const CONTROLLER_PREFIX = 'Controller';
	const DEFAULT_CONTROLLER = 'index';
	const ERROR_CONTROLLER = 'error';
	const DEFAULT_ACTION = 'index';

	public function run() {
		$request = new Lib_Request;
		$controller = $this->_buildControllerName($request->getControllerName());
		$action = $this->_buildActionName($request->getActionName());

		if (!class_exists($controller))
			$controller = $this->_buildControllerName(self::ERROR_CONTROLLER);

		$controller = new $controller;

		if (!method_exists($controller, $action)) {
			$action = self::DEFAULT_ACTION;
		}

		$controller->preDispatch();
		$controller->$action();
		$controller->postDispatch();
	}

	private function _buildControllerName($name) {
		if (empty($name))
			$name = self::DEFAULT_CONTROLLER;
		return self::CONTROLLER_PREFIX . '_' . ucfirst($name);
	}

	private function _buildActionName($name) {
		if (empty($name))
			$name = self::DEFAULT_ACTION;
		return $name;
	}

}
