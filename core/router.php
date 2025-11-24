<?php

namespace Core;

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string and script path
        $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $path = substr($uri, strlen($scriptName));
        $path = strtok($path, '?');
        $path = '/' . ltrim($path, '/');

        if ($path === '//') $path = '/';
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }
        if (empty($path)) $path = '/';

        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            // Convert route to regex
            $pattern = "@^" . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route) . "$@D";

            if (preg_match($pattern, $path, $matches)) {
                // Filter out numeric keys from matches
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                [$controller, $action] = $callback;
                $controllerInstance = new $controller();
                return call_user_func_array([$controllerInstance, $action], $params);
            }
        }

        http_response_code(404);
        require __DIR__ . '/../app/views/errors/404.php';
    }
}
