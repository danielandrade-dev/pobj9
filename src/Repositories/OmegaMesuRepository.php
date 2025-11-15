<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\Interfaces\RepositoryInterface;

class OmegaMesuRepository implements RepositoryInterface
{
    private EntityManager $entityManager;
    private Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $entityManager->getConnection();
    }

    public function findAll(): array
    {
        $sql = "SELECT DISTINCT
                    segmento_label AS segmento,
                    segmento_id,
                    diretoria_label AS diretoria,
                    diretoria_id,
                    regional_label AS gerencia_regional,
                    regional_id AS gerencia_regional_id,
                    agencia_label AS agencia,
                    agencia_id,
                    gerente_gestao,
                    gerente_gestao_id,
                    gerente,
                    gerente_id
                FROM d_unidade
                WHERE segmento IS NOT NULL
                ORDER BY segmento_label, diretoria_label, regional_label, agencia_label";

        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        // Mapeia nomes de colunas para o formato esperado pelo JavaScript
        return array_map(function ($row) {
            return [
                'Segmento' => $row['segmento'] ?? null,
                'Id Segmento' => isset($row['segmento_id']) ? (string)$row['segmento_id'] : null,
                'Diretoria' => $row['diretoria'] ?? null,
                'ID Diretoria' => isset($row['diretoria_id']) ? (string)$row['diretoria_id'] : null,
                'Gerencia Regional' => $row['gerencia_regional'] ?? null,
                'Id Gerencia Regional' => isset($row['gerencia_regional_id']) ? (string)$row['gerencia_regional_id'] : null,
                'Agencia' => $row['agencia'] ?? null,
                'Id Agencia' => isset($row['agencia_id']) ? (string)$row['agencia_id'] : null,
                'Gerente de Gestao' => $row['gerente_gestao'] ?? null,
                'Id Gerente de Gestao' => $row['gerente_gestao_id'] ?? null,
                'Gerente' => $row['gerente'] ?? null,
                'Id Gerente' => $row['gerente_id'] ?? null,
            ];
        }, $results);
    }
}

