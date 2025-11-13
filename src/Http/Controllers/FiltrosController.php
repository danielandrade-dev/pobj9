<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Http\Handlers\FiltrosHandler;
use Pobj\Api\Response\ResponseHelper;

/**
 * Controller para endpoint de filtros
 */
class FiltrosController
{
    /**
     * Retorna filtros por nível
     *
     * @param array<string, mixed> $params
     * @param mixed $payload
     */
    public function handle(array $params, $payload = null): void
    {
        $nivel = $params['nivel'] ?? '';
        if (empty($nivel)) {
            ResponseHelper::error('Parâmetro "nivel" é obrigatório', 400);
        }

        $pdo = DatabaseConnection::getConnection();
        $handler = new FiltrosHandler($pdo);
        $handler->handle($nivel);
    }
}

