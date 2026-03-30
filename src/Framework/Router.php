<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private $routes = [];

    public function add(string $method,string $path){
        $path = $this->normalizePath($path);

        $this->routes[] = [
            "path" => $path,
            "method" => strtoupper($method)
        ];
    }
    private function normalizePath(string $path){
        $path = trim($path, "/");
        $path = "/{$path}/";
        return $path;
    }
}