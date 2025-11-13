<?php

declare(strict_types=1);

namespace Pobj\Api\Response;

class ResponseHelper
{
    public static function json($data): void
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function error(string $message, int $status = 400): void
    {
        if ($status >= 500) {
            \Pobj\Api\Helpers\Logger::error("HTTP $status: $message", [
                'status' => $status,
                'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
            ]);
        } elseif ($status >= 400) {
            \Pobj\Api\Helpers\Logger::warning("HTTP $status: $message", [
                'status' => $status,
                'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
            ]);
        }

        http_response_code($status);
        echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
