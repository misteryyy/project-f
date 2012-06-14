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
    get_include_path()
)));

//EDIT library in application
set_include_path(implode(PATH_SEPARATOR, array(
		realpath(APPLICATION_PATH . '/library'),
		get_include_path(),
)));

// Custom functions to help development
require_once APPLICATION_PATH . '/../library/Utils.php';

// Activate PSR-0 Autoloading; pseudo-namespaces defined in application.ini
include "Zend/Loader/Autoloader.php";
Zend_Loader_Autoloader::getInstance();



// Bootstrap with initialization in manyfiles
$application = new Zend_Application(
		APPLICATION_ENV,
		array( 'config' => array(
						APPLICATION_PATH . '/configs/application.ini',
				)
				)
				);


$application->bootstrap()
            ->run();

 