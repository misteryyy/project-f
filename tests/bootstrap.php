<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

// library in application
set_include_path(implode(PATH_SEPARATOR, array(
		realpath(APPLICATION_PATH . '/library'),
		get_include_path(),
)));


include "Zend/Loader/Autoloader.php";
Zend_Loader_Autoloader::getInstance();

require_once 'ModelTestCase.php';
// Creating application
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Bootstrapping resources
$application->bootstrap();