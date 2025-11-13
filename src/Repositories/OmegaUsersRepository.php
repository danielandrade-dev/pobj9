<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Helpers\EnvHelper;

class OmegaUsersRepository implements RepositoryInterface
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
            "SELECT id, nome, funcional, matricula, cargo, usuario, analista, supervisor, admin,
                    encarteiramento, meta, orcamento, pobj, matriz, outros
             FROM {$tableName}
             ORDER BY nome"
        );

        return $rows ?: [];
    }

    private function getTableName(): string
    {
        $prefix = EnvHelper::get('DB_TABLE_PREFIX', '');
        return $prefix . 'omega_usuarios';
    }
}

