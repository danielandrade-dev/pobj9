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
                    segmento AS segmento,
                    id_segmento AS segmento_id,
                    diretoria AS diretoria,
                    id_diretoria AS diretoria_id,
                    regional AS gerencia_regional,
                    id_regional AS gerencia_regional_id,
                    agencia AS agencia,
                    id_agencia AS agencia_id,
                    nome AS gerente_gestao,
                    funcional AS gerente_gestao_id,
                    nome AS gerente,
                    funcional AS gerente_id
                FROM d_estrutura
                WHERE segmento IS NOT NULL
                ORDER BY segmento, diretoria, regional, agencia";

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

