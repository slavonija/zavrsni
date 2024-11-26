<?php

namespace App\Services;

use App\Events\RegisterEvent;
use App\Interfaces\AuthServiceInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Console\JWTGenerateSecretCommand;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    public function register(array $data): Enumerable
    {
        $user = User::create($data);
        $role = Role::where('name', 'User')->firstOrFail();
        $role->users()->attach($user);

        $token = Auth::login($user);

        RegisterEvent::dispatch($user);

        return $this->respondWithTokens($token, $user);
    }



    public function login(array $data): Enumerable
    {
        if (!$token = Auth::attempt($data)) {
            throw new \Exception('Invalid credentials', 401);
        }
        return $this->respondWithTokens($token, Auth::user());
    }


    public function refresh(array $data): Enumerable
    {
        $refreshToken = $data['refresh_token'];

        $newToken = JWTAuth::claims(['is_refresh_token' => false])->setToken($refreshToken)->refresh();
        $user = JWTAuth::authenticate($newToken);

        return $this->respondWithTokens($newToken, $user);
    }



    public function logout(): array
    {
        Auth::logout(true);

        return ['message' => 'Successfully logged out'];
    }

    private function respondWithTokens(string $token, User $user): Enumerable
    {
        return collect([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL(),
            'refresh_token' => JWTAuth::claims(['is_refresh_token' => true])->fromUser($user),
        ]);
    }
}
