<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Facades\Route;

Route::get('/', HomeController::class, 'index');

Route::get('/register', AuthController::class, 'showRegister');
Route::post('/register', AuthController::class, 'register');
Route::get('/login', AuthController::class, 'showLogin');
Route::post('/login', AuthController::class, 'login');
Route::get('/logout', AuthController::class, 'logout');

Route::get('/admin/dashboard', AdminController::class, 'dashboard');
Route::get('/admin/users', AdminController::class, 'showUsers');

Route::dispatch();