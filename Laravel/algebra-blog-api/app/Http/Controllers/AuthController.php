<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\AuthServiceInterface;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller

{
    private AuthServiceInterface $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Register a new user
     *
     * @param ReisterRequest $request
     * @return JsonResponse
     */

    public function register(RegisterRequest $request): JsonResponse
    {
        $serviceAction = fn() => $this->authService->register($request->validated());
        return $this->executeServiceAction($serviceAction);
    }

    /**
     * Login a user
     *
     * @param LoginRequest $request
     * @return JsonResponse
    */
    public function login(LoginRequest $request): JsonResponse
    {
        $serviceAction = fn() => $this->authService->login($request->validated());
        return $this->executeServiceAction($serviceAction);
    }

    /**
     * Refresh the token
     *
     * @return JsonResponse
     */
    public function refresh(RefreshRequest $request): JsonResponse
    {
        $serviceAction = fn() => $this->authService->refresh($request->validated());
        return $this->executeServiceAction($serviceAction);
    }

    /**
     * Logout a user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $serviceAction = fn() => $this->authService->logout();
        return $this->executeServiceAction($serviceAction);
    }
}
