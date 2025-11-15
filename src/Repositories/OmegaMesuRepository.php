<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\OmegaMesuDTO;
use Pobj\Api\Helpers\RowMapper;
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
        
        return array_map(function ($row) {
            $dto = new OmegaMesuDTO(
                segmento: $row['segmento'] ?? null,
                segmentoId: RowMapper::toString($row['segmento_id'] ?? null),
                diretoria: $row['diretoria'] ?? null,
                diretoriaId: RowMapper::toString($row['diretoria_id'] ?? null),
                gerenciaRegional: $row['gerencia_regional'] ?? null,
                gerenciaRegionalId: RowMapper::toString($row['gerencia_regional_id'] ?? null),
                agencia: $row['agencia'] ?? null,
                agenciaId: RowMapper::toString($row['agencia_id'] ?? null),
                gerenteGestao: $row['gerente_gestao'] ?? null,
                gerenteGestaoId: RowMapper::toString($row['gerente_gestao_id'] ?? null),
                gerente: $row['gerente'] ?? null,
                gerenteId: RowMapper::toString($row['gerente_id'] ?? null),
            );
            
            return $dto->toArray();
        }, $results);
    }
}

