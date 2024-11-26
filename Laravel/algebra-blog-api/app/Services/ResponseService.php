<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use JsonSerializable;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ResponseService
{
    public static function success(array|JsonSerializable $data, int $status = 200): JsonResponse
    {
        return response()->json(['status' => 'OK', 'data' => $data], $status);
    }

    public static function error(\Throwable $e): JsonResponse
    {
        return response()->json(
            data: ['status' => 'ERR', 'message' => $e->getMessage()],
            status: self::getStatusCode($e)
        );
    }

    private static function getStatusCode(\Throwable $e): int
    {
        if ($e instanceof RouteNotFoundException) {
            return 401;
        }

        return $e->getCode() ?: 400;
    }
}
