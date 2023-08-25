<?php 
session_start();
require 'vendor/autoload.php';
require __DIR__ . '/init.php';

use classes\Router;

$router = new Router();

$GLOBALS['config']['GET_ID'] = NULL;

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;  
} else {
    $router->get_data($_SERVER['REQUEST_URI']);
    $GLOBALS['config']['GET_ID'] = $router->get_data;
    $router->route($_SERVER['REQUEST_URI']);
}






