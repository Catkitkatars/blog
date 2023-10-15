<?php 
session_start();

require __DIR__ . '/../init.php';
require __DIR__  . '/../vendor/autoload.php';

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;  
} 


$uri = $_SERVER['REQUEST_URI'] ?? '';

$locator = parse_url($uri, PHP_URL_PATH);

$router = new app\Router([
    '~^/$~' => '/index.php', // Переход на index.php файл
    '~^/posts$~' => '/post/posts.php',
]);

[$path, $params] = $router->route($locator);

$checkPath = realpath($GLOBALS['config']['dir']['pages'] . $path);

if($checkPath) {
    require $checkPath;
}
else
{
    require $GLOBALS['config']['dir']['pages'] . '/404.php';
}



