<?php

class Lib_Application {

	private $_dispatcher;

	// autoloader variables
	private $_alLibPrefix;
	private $_alLibLen;

	public function __construct() {
		$this->_alLibPrefix = ucfirst(strtolower(LIBDIR)) . '_';
		$this->_alLibLen = strlen($this->_alLibPrefix);
		spl_autoload_register(array($this, 'autoload'));
	}

	public function setDispatcher($dispatcher) {
		$this->_dispatcher = $dispatcher;
	}

	public function run() {
		$this->_dispatcher->run();
	}

	// register autoloader, surpress exceptions, prepend default loader
	public function registerAutoloader($loader) {
		if (!empty($loader) && is_callable($loader))
			spl_autoload_register($loader, false, true);
	}

	public function autoload($class) {
		if (class_exists($class, false) || interface_exists($class, false))
			return;

		$file = ($this->_libraryClass($class) ? '' : APPDIR . DS)
			. str_replace('_', DS, strtolower($class)) . '.php';

		if (!file_exists(BASEDIR . $file))
			return;

		require_once $file;

		if (!class_exists($class, false) && !interface_exists($class, false)) {
			die("Loaded '$file' but '$class' not found within\n");
		}
	}

	private function _libraryClass($class) {
		return (substr($class, 0, $this->_alLibLen) == $this->_alLibPrefix);
	}

}
