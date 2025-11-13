<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

use Pobj\Api\Enums\HttpMethod;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Helpers\Logger;
use Pobj\Api\Response\ResponseHelper;

class ApiHandler
{
    public function handle(string $requestPath, string $requestUri): void
    {
        header('Content-Type: application/json; charset=utf-8');
        
        $_SERVER['PATH_INFO'] = substr($requestPath, 4);
        parse_str(parse_url($requestUri, PHP_URL_QUERY) ?? '', $_GET);
        
        $endpoint = null;
        $params = null;
        $method = null;
        
        try {
            $endpoint = $_GET['endpoint'] ?? '';
            if (empty($endpoint) && !empty($_SERVER['PATH_INFO'])) {
                $endpoint = trim($_SERVER['PATH_INFO'], '/');
            }
            
            // Normaliza o endpoint: remove /api/ se presente, depois adiciona api/ para bater com as rotas registradas
            $endpoint = trim($endpoint, '/');
            $endpoint = preg_replace('#^api/#', '', $endpoint);
            
            // Se o endpoint estiver vazio após normalização, retorna 404
            if (empty($endpoint)) {
                ResponseHelper::error('endpoint não encontrado', HttpStatusCode::NOT_FOUND->value);
            }
            
            $endpoint = 'api/' . $endpoint;
            
            $params = $_GET;
            $method = $_SERVER['REQUEST_METHOD'] ?? HttpMethod::GET->value;
            
            $payload = $this->getPayload($method);

            $router = new Router();
            $routesConfig = require __DIR__ . '/routes.php';
            $routesConfig($router);

            $router->dispatch($endpoint, $method, $params, $payload);
        } catch (\Throwable $e) {
            Logger::exception($e, [
                'endpoint' => $endpoint,
                'params' => $params,
                'method' => $method,
            ]);

            http_response_code(HttpStatusCode::INTERNAL_SERVER_ERROR->value);
            echo json_encode([
                'error' => 'server_error',
                'message' => 'Ocorreu um erro interno. Verifique os logs para mais detalhes.',
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    private function getPayload(string $method): ?array
    {
        $methodsWithPayload = [HttpMethod::POST->value, HttpMethod::PUT->value, HttpMethod::PATCH->value];
        if (!in_array($method, $methodsWithPayload, true)) {
            return null;
        }

        $rawInput = file_get_contents('php://input');
        if ($rawInput === false || $rawInput === '') {
            return null;
        }

        return json_decode($rawInput, true);
    }
}

