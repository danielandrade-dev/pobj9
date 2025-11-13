<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Handlers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Response\ResponseHelper;

class StatusIndicadoresHandler
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function handle(): void
    {
        $rows = DatabaseConnection::query(
            $this->pdo,
            'SELECT id, status FROM d_status_indicadores ORDER BY id'
        );
        if (!$rows) {
            $rows = [
                ['id' => '01', 'status' => 'Atingido'],
                ['id' => '02', 'status' => 'Não Atingido'],
                ['id' => '03', 'status' => 'Todos'],
            ];
        }
        ResponseHelper::json(['rows' => $rows]);
    }
}
