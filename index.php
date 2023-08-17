<?php 
session_start();
require 'vendor/autoload.php';
require __DIR__ . '/init.php';

use classes\Router;

$router = new Router();

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;  
} else {
    $router->route($_SERVER['REQUEST_URI']);
}






