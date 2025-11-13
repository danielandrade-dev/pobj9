<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Helpers\EnvHelper;

class OmegaTicketsRepository implements RepositoryInterface
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
            "SELECT id, subject, company, product_id, product_label, family, section,
                    queue, category, status, priority, opened, updated, due_date,
                    requester_id, owner_id, team_id, history, diretoria, gerencia,
                    agencia, gerente_gestao, gerente, credit, attachment
             FROM {$tableName}
             ORDER BY updated DESC, opened DESC"
        );

        return $rows ?: [];
    }

    private function getTableName(): string
    {
        $prefix = EnvHelper::get('DB_TABLE_PREFIX', '');
        return $prefix . 'omega_chamados';
    }
}

