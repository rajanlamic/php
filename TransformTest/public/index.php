<?php

// set include path
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . '/Application');

// register autoload, recognize namespace,
spl_autoload_register(function ($class) {
            require dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        });

// handle exception
set_exception_handler(function($exception) {
            echo $exception->getMessage(), "\n";
            echo '<pre>' . print_r(debug_backtrace(), 1) . '</pre>';
        }
);

// display error on development environment
if ((isset($_SERVER['APPLICATION_ENV'])) && ($_SERVER['APPLICATION_ENV'] == 'development') ) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

use \Application\Application;
use \Application\Event\Pubsub;

// run the application
$application = new Application;
$application->init(require 'Config/global.config.php')->run(new Pubsub());