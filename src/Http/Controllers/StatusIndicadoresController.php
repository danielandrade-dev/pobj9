<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Http\Handlers\StatusIndicadoresHandler;
use Pobj\Api\Response\ResponseHelper;

/**
 * Controller para endpoint de status de indicadores
 */
class StatusIndicadoresController
{
    /**
     * Retorna lista de status de indicadores
     *
     * @param array<string, mixed> $params
     * @param mixed $payload
     */
    public function handle(array $params, $payload = null): void
    {
        $pdo = DatabaseConnection::getConnection();
        $handler = new StatusIndicadoresHandler($pdo);
        $handler->handle();
    }
}

