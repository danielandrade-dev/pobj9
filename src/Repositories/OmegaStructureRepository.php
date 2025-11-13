<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Helpers\EnvHelper;

class OmegaStructureRepository implements RepositoryInterface
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
            "SELECT departamento, departamento_id, ordem_departamento, tipo, ordem_tipo
             FROM {$tableName}
             ORDER BY ordem_departamento ASC, ordem_tipo ASC, departamento ASC, tipo ASC"
        );

        return $rows ?: [];
    }

    private function getTableName(): string
    {
        $prefix = EnvHelper::get('DB_TABLE_PREFIX', '');
        return $prefix . 'omega_departamentos';
    }
}

