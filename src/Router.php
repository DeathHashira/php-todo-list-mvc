<?php

namespace Src;

/**
 * Simple implementation of Router
 * save each path and handler function for each method
 */
class Router
{

    private static $routes = [
        'get' => [],
        'post' => [],
    ];

    private static function getPath(): string
    {
        return parse_url($_SERVER["REQUEST_URI"])["path"];
    }

    private static function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public static function get(string $route, callable $callback): void
    {
        self::$routes['get'][$route] = $callback;
    }

    public static function post(string $route, callable $callback): void
    {
        self::$routes['post'][$route] = $callback;
    }

    /**
     * Find the specific handler for method and path
     * and invoke it
     *
     * @return void
     */
    public static function run()
    {
        $callable = Router::$routes[Router::getMethod()][Router::getPath()] ?? null;
        if (is_callable($callable)) {
            $callable();
        }
    }
}
