<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASEDIR', dirname(getcwd()) . DS);
define('VENDOR',  BASEDIR . 'vendor');
define('APPDIR', 'app');
define('LIBDIR', 'lib');

set_include_path(
	get_include_path() . PATH_SEPARATOR . BASEDIR . PATH_SEPARATOR . VENDOR
);
require LIBDIR . DS . 'application.php';

$zendLoader = function($class) {
	if (substr($class, 0, 5) != 'Zend_' ||
		class_exists($class, false) || interface_exists($class, false))
		return;

	$file = VENDOR . DS . str_replace('_', DS, $class) . '.php';

	if (!file_exists($file))
		return;

	require_once $file;

	if (!class_exists($class, false) && !interface_exists($class, false)) {
		die("Loaded '$file' but '$class' not found within\n");
	}
};

$webApp = new Lib_Application;
$webApp->registerAutoloader($zendLoader);
$webApp->setDispatcher(new Lib_Dispatcher);
$webApp->run();
