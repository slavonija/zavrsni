<?php

namespace App\Http\Middleware;

use App\Services\ResponseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request):
     * (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = JWTAuth::parseToken();
            $refresh = $token->getClaim('is_refresh_token');

            if ($refresh) {
                return ResponseService::error(new \Exception('Invalid token', 401));
            }
        } catch (\Exception $e) {
            return ResponseService::error(new \Exception('Unauthorized', 401));
        }

        return $next($request);
    }
}
