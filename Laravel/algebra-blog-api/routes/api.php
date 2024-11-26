<?php

use App\Http\Controllers\AuthController;
use App\Services\AuthService;
use Illuminate\Support\Facades\Route;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth as FacadesAuth;

Route::post('register', AuthController::class.'@register');
Route::post('login', AuthController::class.'@login');
Route::post('refresh', AuthController::class.'@refresh');

Route::get('/', function () {
    dd(new AuthServiceInterface());
});

Route::group(['middleware' => ['auth:api', 'auth.verify.token']], function () {
    Route::get('/test', function () {
        return 'Hello World';
    });

    Route::get('logout', AuthController::class.'@logout');
});
