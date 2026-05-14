<?php

namespace App\Core;

use App\Middleware\RoleMiddleware;

class Router
{
    private static array $routes = [];
    private static array $groupAttributes = [];

    public static function get(string $uri, array $action, ?string $middleware = null): void
    {
        self::addRoute('GET', $uri, $action, $middleware);
    }

    public static function post(string $uri, array $action, ?string $middleware = null): void
    {
        self::addRoute('POST', $uri, $action, $middleware);
    }

    private static function addRoute(string $method, string $uri, array $action, ?string $middleware): void
    {
        $finalMiddleware = $middleware ?? (self::$groupAttributes['middleware'] ?? null);

        self::$routes[$method][$uri] = [
            'action'     => $action,
            'middleware' => $finalMiddleware,
        ];
    }

    public static function group(array $attributes, callable $callback): void
    {
        $previousGroup = self::$groupAttributes;

        if (isset($attributes['middleware'])) {
            self::$groupAttributes['middleware'] = $attributes['middleware'];
        }

        call_user_func($callback);

        self::$groupAttributes = $previousGroup;
    }

    public static function dispatch(): void
    {
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        [$route, $params] = self::match($method, $uri);

        if ($route === null) {
            http_response_code(404);
            View::render('error.404');
            return;
        }

        // CSRF Verification for POST requests
        if ($method === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!Session::verifyCsrfToken($token)) {
                http_response_code(403);
                Session::setMessage('error', 'Token CSRF tidak valid.');
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
                exit;
            }
        }

        RoleMiddleware::handle($route['middleware']);

        [$controllerClass, $methodName] = $route['action'];
        $controller = new $controllerClass();
        $controller->$methodName(...$params);
    }

    private static function match(string $method, string $uri): array
    {
        $routes = self::$routes[$method] ?? [];

        foreach ($routes as $routeUri => $route) {
            $pattern = preg_replace('#:([a-zA-Z_]+)#', '([^/]+)', $routeUri);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return [$route, $matches];
            }
        }

        return [null, []];
    }
}