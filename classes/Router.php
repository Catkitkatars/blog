<?php 

namespace classes;

class Router {
    public $get_data = NULL;

    public function get_data($uri) {
        preg_match('/[0-9]+/', $uri, $matches);
        if($matches) {
            $this->get_data = $matches[0];
            return $uri = str_replace('/' . $matches[0] , '', $uri);
        }
        else 
        {
            return $uri;
        }
    }


    public function route($uri) {
        $valid_paths = ['/../pages', '/../requests', '/../test'];
        $path_founded = false;
        
        if($uri == '/') {  
            require 'pages/main.php';
        }
        else 
        {   
            $uri = $this->get_data($uri);

            if($uri == '/posts/post' && !$this->get_data) {
                require 'pages/404.php';
                return;
            }

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


