<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASEDIR', dirname(getcwd()) . DS);

set_include_path(get_include_path() . PATH_SEPARATOR . BASEDIR);
require 'lib' . DS . 'application.php';

$webApp = new Application;
$webApp->registerAutoloaders();
$webApp->setDispatcher(new Dispatcher);
$webApp->run();
