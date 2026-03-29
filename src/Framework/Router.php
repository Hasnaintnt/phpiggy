<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private $routes = [];

    public function add(string $method,string $path){
        $this->routes[] = [
            "path" => $path,
            "method" => strtoupper($method)
        ];
    }
}