<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/bootstrap.php';

use Pobj\Api\Enums\HttpMethod;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Http\Router;
use Pobj\Api\Response\ResponseHelper;

try {
    $endpoint = $_GET['endpoint'] ?? '';
    if (empty($endpoint) && !empty($_SERVER['PATH_INFO'])) {
        $endpoint = trim($_SERVER['PATH_INFO'], '/');
    }
    
    $params = $_GET;
    $method = $_SERVER['REQUEST_METHOD'] ?? HttpMethod::GET->value;
    
    $payload = null;
    $methodsWithPayload = [HttpMethod::POST->value, HttpMethod::PUT->value, HttpMethod::PATCH->value];
    if (in_array($method, $methodsWithPayload, true)) {
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

    http_response_code(HttpStatusCode::INTERNAL_SERVER_ERROR->value);
    echo json_encode([
        'error' => 'server_error',
        'message' => 'Ocorreu um erro interno. Verifique os logs para mais detalhes.',
    ], JSON_UNESCAPED_UNICODE);
}
