<?php

namespace App\Traits;

trait JsonResponseTrait
{
    protected function jsonSuccess($data = null, string $message = ''): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $data,
            'message' => $message
        ]);
        exit;
    }

    protected function jsonError(string $message = '', $data = null, int $statusCode = 400): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'data' => $data,
            'message' => $message
        ]);
        exit;
    }
}
