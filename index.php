<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

error_reporting(E_ALL);
set_error_handler('app\core\Error::errorHandler');
set_exception_handler('app\core\Error::exceptionHandler');

$db = \app\core\Database::getInstance();

$router = new app\core\Router();

// Add the routes
$router->add('', ['controller' => 'IndexController', 'action' => 'index']);
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['REQUEST_URI']);
