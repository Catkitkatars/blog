<?php 
session_start();

require __DIR__ . '/../src/init.php';
require __DIR__  . '/../src/vendor/autoload.php';

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;  
} 

$uri = $_SERVER['REQUEST_URI'] ?? '';

$locator = parse_url($uri, PHP_URL_PATH);

$router = new app\Router([
    '~^/$~' => '/index.php', 
    '~^/test$~' => '/test/test.php',
    '~^/(?<module>[^/]+)$~' => '/{module}/posts.php',
    '~^/(?<module>[^/]+)/logout$~' => '/{module}/logout.php',
    '~^/(?<module>[^/]+)/signup$~' => '/{module}/signup.php',
    '~^/(?<module>[^/]+)/login$~' => '/{module}/login.php',
    '~^/(?<module>[^/]+)/edit$~' => '/{module}/add_post.php',
    '~^/(?<module>[^/]+)/(?<id>.+)$~' => '/{module}/post_page.php',
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



