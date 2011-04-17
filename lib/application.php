<?php

class Application {

	private $_dispatcher;

	public function setDispatcher($dispatcher) {
		$this->_dispatcher = $dispatcher;
	}

	public function run() {
		$this->_dispatcher->run();
	}

	public function registerAutoloaders($loaders = null) {
		spl_autoload_register(array($this, 'autoload'));
		if (!empty($loaders))
			$this->_registerThirdPartyAutoloaders($loaders);
	}

	public function autoload($class) {
		if (class_exists($class, false))
			return;

		$viewPath = 'app' . DS . 'views' . DS;
		$dirs = array('app', 'lib');

		foreach ($dirs as $dir) {
			$file = $dir . DS . str_replace('_', DS, strtolower($class)) . '.';
			$file .= (strpos($file, $viewPath) !== false) ? 'phtml' : 'php';

			if ($this->_fileExistsInAppDir($file))
				break;
		}

		if (!file_exists(BASEDIR . $file))
			die("File does not exist '$file'\n");

		require_once $file;

		if (!class_exists($class) && !interface_exists($class)) {
			die("Loaded '$file' but '$class' not found within\n");
		}
	}

	// register autoloaders, surpress exceptions, prepend default loader
	private function _registerThirdPartyAutoloaders($autoloaders) {
		foreach ($autoloaders as $loader) {
			if (is_callable($loader))
				spl_autoload_register($loader, false, true);
		}
	}

	private function _fileExistsInAppDir($file) {
		return (substr($file, 0, 4) == 'app' . DS && file_exists($file));
	}

}
