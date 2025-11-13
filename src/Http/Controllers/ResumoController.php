<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Http\Handlers\ResumoHandler;
use Pobj\Api\Response\ResponseHelper;

class ResumoController
{
    public function handle(array $params, $payload = null): void
    {
        $pdo = DatabaseConnection::getConnection();
        $handler = new ResumoHandler($pdo);
        $handler->handle($params);
    }
}
