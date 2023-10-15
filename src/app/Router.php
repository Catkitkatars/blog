<?php

namespace app;

class Router {

    public function __construct(private array $settings) {}


    public function route(string $uri): array {
        $matches = [];
        foreach($this->settings as $pattern => $value) {
            if(preg_match($pattern, $uri, $matches)) {
                $upadted_matches = [];
                $params = [];
                foreach($matches as $key => $match) {
                    if(is_string($key)) {
                        $params[$key] = $matches[$key];
                        $upadted_matches['{' . $key . '}'] = $matches[$key]; 
                    }
                }
                $path = strtr($value, $upadted_matches);

                return [$path, $params];
            }
        }
    }
}