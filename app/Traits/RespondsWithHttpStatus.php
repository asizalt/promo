<?php

namespace App\Traits;

trait RespondsWithHttpStatus
{
    protected function success($message, $data = [], $status = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function failure($message, $status = 422)
    {
        return response()->json([
            'success' => false,
        ], $status);
    }
}
