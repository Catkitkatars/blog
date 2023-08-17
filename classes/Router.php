<?php 

namespace classes;

class Router {
    public function route($uri) {
        $valid_paths = ['/../pages', '/../requests', '/../test'];
        $path_founded = false;

        if($uri == '/') {  
            require 'pages/main.php';
        }
        else 
        {
            foreach($valid_paths as $valid_path) {
                
                $pages_dir = realpath(__DIR__ . $valid_path);
                $path = $pages_dir . $uri . '.php';
                $real_path = realpath($path);

                if(str_starts_with($real_path, $pages_dir)) {
                    require $real_path;
                    $path_founded = true;
                    break;
                }
            }
            if(!$path_founded) {
                require 'pages/404.php';
            }
        }
    }
}


// Есть ли смысл удалять дубли из uri, чтобы решить проблему перехода на страницу внутри страницы, а не формировался путь auth/auth/login.php 
