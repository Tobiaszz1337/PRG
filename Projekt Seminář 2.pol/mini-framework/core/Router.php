<?php

class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    // Register routes
    public function get(string $path, string $controller, string $action): void
    {
        $this->addRoute('GET', $path, $controller, $action);
    }

    public function post(string $path, string $controller, string $action): void
    {
        $this->addRoute('POST', $path, $controller, $action);
    }

    public function put(string $path, string $controller, string $action): void
    {
        $this->addRoute('PUT', $path, $controller, $action);
    }

    public function delete(string $path, string $controller, string $action): void
    {
        $this->addRoute('DELETE', $path, $controller, $action);
    }

    private function addRoute(string $method, string $path, string $controller, string $action): void
    {
        // Convert :param to named regex groups
        $pattern = preg_replace('/\/:([a-zA-Z_]+)/', '/(?P<$1>[^/]+)', $path);
        $pattern = '@^' . $pattern . '$@';

        $this->routes[] = [
            'method'     => strtoupper($method),
            'path'       => $path,
            'pattern'    => $pattern,
            'controller' => $controller,
            'action'     => $action,
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        // Support method override via hidden _method field or header
        if ($method === 'POST') {
            if (!empty($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);
            } elseif (!empty($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
                $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
            }
        }

        $uri = $this->getUri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                // Extract named params only
                $params = array_filter($matches, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);

                $controllerClass = $route['controller'];
                $action          = $route['action'];

                if (!class_exists($controllerClass)) {
                    $this->abort(500, "Controller '{$controllerClass}' not found.");
                    return;
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $action)) {
                    $this->abort(500, "Action '{$action}' not found on {$controllerClass}.");
                    return;
                }

                $controller->$action(...array_values($params));
                return;
            }
        }

        $this->abort(404, "No route matched: [{$method}] {$uri}");
    }

    private function getUri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Strip base path
        if ($this->basePath && str_starts_with($uri, $this->basePath)) {
            $uri = substr($uri, strlen($this->basePath));
        }
        return '/' . ltrim($uri, '/');
    }

    private function abort(int $code, string $message): void
    {
        http_response_code($code);
        echo "<h1>Error {$code}</h1><p>" . htmlspecialchars($message) . "</p>";
    }
}
