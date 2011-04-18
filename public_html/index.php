<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASEDIR', dirname(getcwd()) . DS);
define('APPDIR', 'app');
define('LIBDIR', 'lib');

set_include_path(get_include_path() . PATH_SEPARATOR . BASEDIR);
require LIBDIR . DS . 'application.php';

$webApp = new Application;
$webApp->registerAutoloaders();
$webApp->setDispatcher(new Dispatcher);
$webApp->run();
