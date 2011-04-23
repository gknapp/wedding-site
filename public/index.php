<?php

error_reporting(E_ALL | E_STRICT);

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

	require $file;

	if (!class_exists($class, false) && !interface_exists($class, false)) {
		die("Loaded '$file' but '$class' not found within\n");
	}
};

$webApp = new Lib_Application;
$webApp->registerAutoloader($zendLoader);
$webApp->setDispatcher(new Lib_Dispatcher);

// assign application dependencies
$container = new Lib_Container;
$container->dsn = 'sqlite:' . BASEDIR . 'data/wedding.db';
$container->dbh = function($c) {
	return new PDO($c->dsn);
};
$container->database = function ($c) {
	return new Lib_Sqlite3($c->dbh);
};
$container->request = new Lib_Request;
$container->session = function($c) {
	return function($namespace) {
		return new Zend_Session_Namespace($namespace);
	};
};

//$start = microtime(true);
$webApp->run($container);
//echo "<p>Runtime: " . round((microtime(true) - $start) * 1000, 2) . " ms</p>";
