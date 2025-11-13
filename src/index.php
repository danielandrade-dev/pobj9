<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/bootstrap.php';

use Pobj\Api\Http\Router;
use Pobj\Api\Response\ResponseHelper;

try {
    $endpoint = $_GET['endpoint'] ?? '';
    if (empty($endpoint) && !empty($_SERVER['PATH_INFO'])) {
        $endpoint = trim($_SERVER['PATH_INFO'], '/');
    }
    
    $params = $_GET;
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    
    $payload = null;
    if (in_array($method, ['POST', 'PUT', 'PATCH'], true)) {
        $rawInput = file_get_contents('php://input');
        if ($rawInput !== false && $rawInput !== '') {
            $payload = json_decode($rawInput, true);
        }
    }

    $router = new Router();
    $routesConfig = require __DIR__ . '/Http/routes.php';
    $routesConfig($router);

    $router->dispatch($endpoint, $method, $params, $payload);
} catch (\Throwable $e) {
    \Pobj\Api\Helpers\Logger::exception($e, [
        'endpoint' => $endpoint ?? null,
        'params' => $params ?? null,
        'method' => $method ?? null,
    ]);

    http_response_code(500);
    echo json_encode([
        'error' => 'server_error',
        'message' => 'Ocorreu um erro interno. Verifique os logs para mais detalhes.',
    ], JSON_UNESCAPED_UNICODE);
}
