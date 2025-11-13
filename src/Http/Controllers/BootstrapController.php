<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Http\Handlers\BootstrapHandler;
use Pobj\Api\Response\ResponseHelper;

class BootstrapController
{
    public function handle(array $params, $payload = null): void
    {
        $pdo = DatabaseConnection::getConnection();
        $handler = new BootstrapHandler($pdo);
        $handler->handle();
    }
}
