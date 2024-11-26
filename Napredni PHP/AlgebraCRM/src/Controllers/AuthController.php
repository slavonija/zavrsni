<?php

namespace App\Controllers;

use App\Middleware\Auth;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showRegister()
    {
        Auth::isAuthenticated();
        $this->render('auth/register', ['title' => 'Register']);
    }

    public function register(): mixed
    {
        Auth::isAuthenticated();
        try {
            $data = $this->getRequestData();   
            $this->userModel->create($data);

            return $this->redirect('/login');

        } catch (\Exception $e) {
            echo 'An error occurred. Please try again.';
        }

        return $this->redirect('/register');
    }

    public function showLogin()
    {
        Auth::isAuthenticated();
        $this->render('auth/login', ['title' => 'Login']);
    }

    public function login(): mixed
    {
        Auth::isAuthenticated();
        try {
            [$email, $password] = array_values(
                $this->getRequestData(['email', 'password'])
            );

            $user = $this->userModel->findByEmail($email);

            if(!$user || !password_verify($password, $user['password'])) {
                return $this->redirect('/login');
            }

            $_SESSION['user'] = $user;

        } catch (\Exception $e) {
            echo 'An error occurred. Please try again.';
        }

        return $this->redirect('/admin/dashboard');
    }

    public function logout()
    {
        Auth::isGuest();
        session_destroy();
        return $this->redirect('/login');
    }
}