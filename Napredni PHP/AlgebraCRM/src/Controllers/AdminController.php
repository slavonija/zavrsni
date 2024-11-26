<?php

namespace App\Controllers;

use App\Middleware\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        Auth::isGuest();
    }

    public function dashboard()
    {
        echo 'Admin Dashboard', '<br>', '<a href="../logout">Logout</a>';	
    }

    public function showUsers()
    {
        echo 'Show Users';
    }
}