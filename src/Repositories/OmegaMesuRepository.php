<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Helpers\EnvHelper;

class OmegaMesuRepository implements RepositoryInterface
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
            "SELECT DISTINCT
                segmento AS Segmento,
                id_segmento AS 'Id Segmento',
                diretoria AS Diretoria,
                id_diretoria AS 'ID Diretoria',
                regional AS 'Gerencia Regional',
                id_regional AS 'Id Gerencia Regional',
                agencia AS Agencia,
                id_agencia AS 'Id Agencia',
                CASE 
                    WHEN cargo LIKE 'Gerente de Gestao%' OR cargo LIKE 'Gerente de Gestão%' 
                    THEN nome 
                    ELSE NULL 
                END AS 'Gerente de Gestao',
                CASE 
                    WHEN cargo LIKE 'Gerente de Gestao%' OR cargo LIKE 'Gerente de Gestão%' 
                    THEN funcional 
                    ELSE NULL 
                END AS 'Id Gerente de Gestao',
                CASE 
                    WHEN cargo LIKE 'Gerente%' AND cargo NOT LIKE 'Gerente de Gest%' 
                    THEN nome 
                    ELSE NULL 
                END AS Gerente,
                CASE 
                    WHEN cargo LIKE 'Gerente%' AND cargo NOT LIKE 'Gerente de Gest%' 
                    THEN funcional 
                    ELSE NULL 
                END AS 'Id Gerente'
             FROM {$tableName}
             WHERE segmento IS NOT NULL
             ORDER BY segmento, diretoria, regional, agencia"
        );

        return $rows ?: [];
    }

    private function getTableName(): string
    {
        $prefix = EnvHelper::get('DB_TABLE_PREFIX', '');
        return $prefix . 'd_estrutura';
    }
}

