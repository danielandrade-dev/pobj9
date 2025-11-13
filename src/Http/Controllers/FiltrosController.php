<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Http\Handlers\FiltrosHandler;
use Pobj\Api\Response\ResponseHelper;

class FiltrosController
{
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
