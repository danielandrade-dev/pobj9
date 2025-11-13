<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Helpers\EnvHelper;

class OmegaStatusRepository implements RepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $tableName = $this->getTableName();
        $rows = DatabaseConnection::query(
            $this->pdo,
            "SELECT id, label, tone, descricao, ordem, departamento_id
             FROM {$tableName}
             ORDER BY ordem ASC, label ASC"
        );

        return $rows ?: [];
    }

    private function getTableName(): string
    {
        $prefix = EnvHelper::get('DB_TABLE_PREFIX', '');
        return $prefix . 'omega_status';
    }
}

