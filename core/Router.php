<?php
namespace Core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable|array $callback): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function dispatch(string $method, string $uri): void {
        $uri = parse_url($uri, PHP_URL_PATH) ?? '/';
        // Strip base path if running from a subdirectory (like /p_001/p_001/public)
        $basePath = '/p_001/public';
        $oldBasePath = '/p_001/p_001/public';
        if (strpos($uri, $oldBasePath) === 0) {
            $uri = substr($uri, strlen($oldBasePath));
        } elseif (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            $params = [];
            $methodMatches = ($route['method'] === $method) || ($method === 'HEAD' && $route['method'] === 'GET');
            if ($methodMatches && $this->match($route['path'], $uri, $params)) {
                if (is_callable($route['callback'])) {
                    call_user_func_array($route['callback'], $params);
                    return;
                }
                
                if (is_array($route['callback'])) {
                    $controllerName = $route['callback'][0];
                    $methodName = $route['callback'][1];
                    $controller = new $controllerName();
                    call_user_func_array([$controller, $methodName], $params);
                    return;
                }
            }
        }

        // 404 Not Found
        http_response_code(404);
        echo "404 Not Found";
    }

    private function match(string $routePath, string $uri, array &$params = []): bool {
        $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_\-]+)', $routePath);
        $routeRegex = "@^" . $routeRegex . "$@D";
        
        $matches = [];
        if (preg_match($routeRegex, $uri, $matches)) {
            array_shift($matches);
            $params = $matches;
            return true;
        }
        return false;
    }
}
