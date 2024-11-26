<?php

namespace App\Facades;

use App\Exceptions\HttpNotFoundException;
use App\Services\Router;

class Route
{
    public static function get(string $path, string $controller, string $action): void
    {
        Router::getInstance()->get($path, $controller, $action);
    }

    public static function post(string $path, string $controller, string $action): void
    {
        Router::getInstance()->post($path, $controller, $action);
    }

    public static function dispatch(): void
    {
        try {
            Router::getInstance()->dispatch();
        } catch (HttpNotFoundException $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            echo $e->getMessage();
        }
    }
}