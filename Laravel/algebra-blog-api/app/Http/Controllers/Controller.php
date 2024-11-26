<?php

namespace App\Http\Controllers;

use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;
//use Illuminate\Support\Facades\Log;



abstract class Controller
{
    protected function executeServiceAction(callable $serviceAction): JsonResponse
    {
        try {
            return ResponseService::success($serviceAction());
        } catch (\Throwable $e) {
            //Log::critical($e->getMessage());
            return ResponseService::error($e);
        }
    }

}
