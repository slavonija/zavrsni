<?php

namespace App\Contracts;

interface RouterInterface
{
    public function get(string $path, string $controller, string $action): void;
    public function post(string $path, string $controller, string $action): void;
    public function dispatch(): void;
}