<?php

declare(strict_types=1);

namespace Pobj\Api\Response;

use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Http\View;

class ResponseHelper
{
    public static function json($data): void
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function view(string $viewName, array $data = [], int $statusCode = HttpStatusCode::OK->value): void
    {
        $projectRoot = dirname(__DIR__, 2);
        $view = new View($projectRoot);
        
        http_response_code($statusCode);
        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        echo $view->render($viewName, $data);
        exit;
    }

    public static function error(string $message, int $status = HttpStatusCode::BAD_REQUEST->value): void
    {
        if ($status >= HttpStatusCode::INTERNAL_SERVER_ERROR->value) {
            \Pobj\Api\Helpers\Logger::error("HTTP $status: $message", [
                'status' => $status,
                'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
            ]);
        } elseif ($status >= HttpStatusCode::BAD_REQUEST->value) {
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
