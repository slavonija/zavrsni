<?php

namespace App\Middleware;

class Auth
{
    public static function check(): void
    {
        if (! isset($_SESSION['user'])) {
            header('Location:'. APP_URL .'/login');
            exit;
        } else {
            header('Location:'. APP_URL .'/admin/dashboard');
        }
    }

    public static function isGuest(): void
    {
        if (! isset($_SESSION['user'])) {
            header('Location:'. APP_URL .'/login');
            exit;
        }
    }

    public static function isAuthenticated(): void
    {
        if (isset($_SESSION['user'])) {
            header('Location:'. APP_URL .'/admin/dashboard');
            exit;
        }
        
    }
}