<?php

namespace App\Core;

use App\Middleware\RoleMiddleware;

class Router
{
    private static array $routes = [];

    public static function get(string $uri, array $action, ?string $middleware = null): void
    {
        self::addRoute('GET', $uri, $action, $middleware);
    }

    public static function post(string $uri, array $action, ?string $middleware = null): void
    {
        self::addRoute('POST', $uri, $action, $middleware);
    }

    public static function put(string $uri, array $action, ?string $middleware = null): void
    {
        self::addRoute('PUT', $uri, $action, $middleware);
    }

    public static function patch(string $uri, array $action, ?string $middleware = null): void
    {
        self::addRoute('PATCH', $uri, $action, $middleware);
    }

    public static function delete(string $uri, array $action, ?string $middleware = null): void
    {
        self::addRoute('DELETE', $uri, $action, $middleware);
    }

    private static function addRoute(string $method, string $uri, array $action, ?string $middleware): void
    {
        self::$routes[$method][$uri] = [
            'action'     => $action,
            'middleware' => $middleware,
        ];
    }

    public static function dispatch(): void
    {
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Method spoofing untuk PUT, PATCH, DELETE dari HTML form
        if ($method === 'POST' && isset($_POST['_method'])) {
            $spoofed = strtoupper($_POST['_method']);
            if (in_array($spoofed, ['PUT', 'PATCH', 'DELETE'])) {
                $method = $spoofed;
            }
        }

        // FIX: satu titik dispatch pakai match() saja
        [$route, $params] = self::match($method, $uri);

        if ($route === null) {
            http_response_code(404);
            View::render('error.404');
            return; // FIX: return agar tidak lanjut eksekusi
        }

        RoleMiddleware::handle($route['middleware']);

        [$controllerClass, $methodName] = $route['action'];
        $controller = new $controllerClass();
        // Spread params agar dynamic segment (misal :id) terkirim ke controller
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