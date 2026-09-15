<?php namespace Src;

class Router {

    private static $routes = [
        'get' => [],
        'post' => [],
    ];

    private static function getPath(): string {
        return parse_url($_SERVER["REQUEST_URI"])["path"];
    }

    private static function getMethod(): string {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public static function get(string $route, callable $callback): void {
        self::$routes['get'][$route] = $callback;
    }

    public static function post(string $route, callable $callback): void {
        self::$routes['post'][$route] = $callback;
    }

    public static function run() {
        $callable = Router::$routes[Router::getMethod()][Router::getPath()];
        $callable();
    }
}