<?php

declare(strict_types=1);

/**
 * API Principal - Ponto de entrada e roteador
 *
 * Este arquivo atua como ponto de entrada da API, roteando requisições
 * para os handlers apropriados baseado no parâmetro 'endpoint'.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/bootstrap.php';

use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Http\Handlers\AgentHandler;
use Pobj\Api\Http\Handlers\BootstrapHandler;
use Pobj\Api\Http\Handlers\FiltrosHandler;
use Pobj\Api\Http\Handlers\ResumoHandler;
use Pobj\Api\Http\Handlers\StatusIndicadoresHandler;
use Pobj\Api\Response\ResponseHelper;

try {
    // Inicializa conexão com banco de dados
    $pdo = DatabaseConnection::getConnection();

    // Obtém endpoint e parâmetros
    // Aceita tanto query string (?endpoint=health) quanto PATH_INFO (/health)
    $endpoint = $_GET['endpoint'] ?? '';
    if (empty($endpoint) && !empty($_SERVER['PATH_INFO'])) {
        $endpoint = trim($_SERVER['PATH_INFO'], '/');
    }
    $params = $_GET;
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    // Roteamento de endpoints
    switch ($endpoint) {
        case 'agent':
            if ($method !== 'POST') {
                ResponseHelper::error('Método não permitido. Use POST.', 405);
            }
            $payload = json_decode(file_get_contents('php://input'), true) ?: [];
            $handler = new AgentHandler();
            $handler->handle($payload);
            break;

        case 'health':
            ResponseHelper::json(['status' => 'ok']);
            break;

        case 'filtros':
            $nivel = $params['nivel'] ?? '';
            $handler = new FiltrosHandler($pdo);
            $handler->handle($nivel);
            break;

        case 'bootstrap':
            $handler = new BootstrapHandler($pdo);
            $handler->handle();
            break;

        case 'status_indicadores':
            $handler = new StatusIndicadoresHandler($pdo);
            $handler->handle();
            break;

        case 'resumo':
            $handler = new ResumoHandler($pdo);
            $handler->handle($params);
            break;

        default:
            ResponseHelper::error('endpoint não encontrado', 404);
    }
} catch (\Throwable $e) {
    // Log do erro
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
