<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Http\Handlers\ResumoHandler;
use Pobj\Api\Response\ResponseHelper;

/**
 * Controller para endpoint de resumo
 */
class ResumoController
{
    /**
     * Retorna resumo com filtros
     *
     * @param array<string, mixed> $params
     * @param mixed $payload
     */
    public function handle(array $params, $payload = null): void
    {
        $pdo = DatabaseConnection::getConnection();
        $handler = new ResumoHandler($pdo);
        $handler->handle($params);
    }
}

