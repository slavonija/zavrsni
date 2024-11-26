<?php

namespace App\Interfaces;

use Illuminate\Support\Enumerable;

interface AuthServiceInterface
{
    public function register(array $data): Enumerable;
    public function login(array $data): Enumerable;
    public function refresh(array $data): Enumerable;
    public function logout(): array;
}
