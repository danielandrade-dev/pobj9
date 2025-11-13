<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Enums\StatusIndicador;

class StatusIndicadoresRepository implements RepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $rows = DatabaseConnection::query(
            $this->pdo,
            'SELECT id, status FROM d_status_indicadores ORDER BY id'
        );

        if (!$rows) {
            return StatusIndicador::getDefaults();
        }

        return $rows;
    }

    public function findAllForFilter(): array
    {
        $rows = DatabaseConnection::query(
            $this->pdo,
            'SELECT id, status AS label FROM d_status_indicadores ORDER BY id'
        );

        if (!$rows) {
            return StatusIndicador::getDefaultsForFilter();
        }

        return $rows;
    }
}
