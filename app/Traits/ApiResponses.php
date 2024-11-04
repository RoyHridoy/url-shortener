<?php

namespace App\Traits;

trait ApiResponses
{
    public function error($message = '', $statusCode = null)
    {
        return response()->json([
            'errors' => [
                'message' => $message,
                'status' => $statusCode
            ]
        ], $statusCode);
    }

    public function ok($message, $data = [])
    {
        return $this->success($message, $data, 200);
    }

    public function success($message, $data = [], $statusCode = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => $statusCode
        ], $statusCode);
    }
}
