<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Http\Handlers\BootstrapHandler;
use Pobj\Api\Response\ResponseHelper;

/**
 * Controller para endpoint bootstrap
 */
class BootstrapController
{
    /**
     * Retorna dados iniciais do frontend
     *
     * @param array<string, mixed> $params
     * @param mixed $payload
     */
    public function handle(array $params, $payload = null): void
    {
        $pdo = DatabaseConnection::getConnection();
        $handler = new BootstrapHandler($pdo);
        $handler->handle();
    }
}

