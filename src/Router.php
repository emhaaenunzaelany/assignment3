<?php

namespace App;

use Illuminate\Http\Request;

class Router
{
    private $routes = [];

    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute($method, $uri, $action)
    {
        $this->routes[] = compact('method', 'uri', 'action');
    }

    public function dispatch($requestUri, $requestMethod)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['uri'] === $requestUri) {
                if (is_callable($route['action'])) {
                    return call_user_func($route['action']);
                } elseif (is_array($route['action']) && count($route['action']) == 2) {
                    [$controller, $method] = $route['action'];
                    if (class_exists($controller) && method_exists($controller, $method)) {
                        return (new $controller)->$method(Request::capture());
                    }
                }
            }
        }

        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Not Found']);
    }
}