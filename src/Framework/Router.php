<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private $routes = [];
    private array $middlewares = [];

    public function add(string $method,string $path,array $controller){
        $path = $this->normalizePath($path);

        $regexPath = preg_replace('#{[^/]+}#','([^/]+)',$path);

        $this->routes[] = [
            "path" => $path,
            "method" => strtoupper($method),
            "controller" => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath
        ];
    }
    private function normalizePath(string $path){
        $path = trim($path, "/");
        $path = "/{$path}/";
        $path = preg_replace("#[/]{2,}#","/",$path);
        return $path;
    }

    public function dispatch(string $path,string $method,Container $container = null){
        $path = $this->normalizePath($path);
        $method = strtoupper($_POST['_METHOD'] ?? $method);

        foreach ($this->routes as $route){
            if(!preg_match("#^{$route["regexPath"]}$#",$path,$paramValues) ||
                $route["method"]!==$method){
                continue;
            }

            array_shift($paramValues);

            preg_match_all('#{([^/]+)}#', $route['path'], $paramKeys);
            $paramKeys = $paramKeys[1];
            $params = $paramKeys ? array_combine($paramKeys, $paramValues) : [];

            [$class,$function] = $route["controller"];
            $classInstance = $container ?
                $container->resolve($class) : new $class();

            $action = fn() => $classInstance->{$function}($params);

            $allMiddleware = [...$route["middlewares"],...$this->middlewares];

            foreach ($allMiddleware as $middleware) {
                $middlewareInstance = $container ?
                    $container->resolve($middleware) :
                    new $middleware;
                $action = (function($next) use ($middlewareInstance) {
                    return fn() => $middlewareInstance->process($next);
                })($action);
            }

            $action();

            return;
            // Ternary operator
            // the same code without ternary operator
            //if($container){
            //      $classInstance = $container->resolve($class);
            //}else{
            //    $classInstance = new $class();
            //}
        }
    }

    public function addMiddleware(string $middleware){
        $this->middlewares[] = $middleware;
    }

    public function addRoutesMiddlewares(string $middleware){
        $lastRouteKey = array_key_last($this->routes);
        $this->routes[$lastRouteKey]["middlewares"][] = $middleware;
    }
}