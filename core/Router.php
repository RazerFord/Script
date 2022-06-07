<?php

namespace app\core;

class Router
{
    private string $namespace = 'app\controllers';

    protected array $routes = [];
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function get($path, $operation)
    {
        $this->routes['get'][$path] = $operation;
    }

    public function post($path, $operation)
    {
        $this->routes['post'][$path] = $operation;
    }

    public function delete($path, $operation)
    {
        $this->routes['delete'][$path] = $operation;
    }

    public function resolve()
    {
        $path = $this->request->getPath();

        $method = $this->request->getMethod();

        $operation = $this->routes[$method][$path] ?? false;

        if ($operation === false) {
            return response(false, 'page not found', null, 404);
        }

        [$controller, $method] = explode('@', $operation);

        return (new ($this->namespace . '\\' . $controller)())->$method();
    }
}
