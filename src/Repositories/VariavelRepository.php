<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\VariavelDTO;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Helpers\RowMapper;
use Pobj\Api\Interfaces\RepositoryInterface;

class VariavelRepository implements RepositoryInterface
{
    private Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function findAllAsArray(): array
    {
        $sql = "SELECT 
                    v.id AS registro_id,
                    v.funcional,
                    v.meta AS variavel_meta,
                    v.variavel AS variavel_real,
                    v.dt_atualizacao AS data,
                    v.dt_atualizacao AS competencia,
                    COALESCE(e.nome, '') AS nome_funcional,
                    COALESCE(e.segmento, '') AS segmento,
                    COALESCE(CAST(e.id_segmento AS CHAR), '') AS segmento_id,
                    COALESCE(e.diretoria, '') AS diretoria_nome,
                    COALESCE(CAST(e.id_diretoria AS CHAR), '') AS diretoria_id,
                    COALESCE(e.regional, '') AS regional_nome,
                    COALESCE(CAST(e.id_regional AS CHAR), '') AS gerencia_id,
                    COALESCE(e.agencia, '') AS agencia_nome,
                    COALESCE(CAST(e.id_agencia AS CHAR), '') AS agencia_id
                FROM f_variavel v
                LEFT JOIN d_estrutura e ON e.funcional COLLATE utf8mb4_unicode_ci = CAST(v.funcional AS CHAR) COLLATE utf8mb4_unicode_ci
                ORDER BY v.dt_atualizacao DESC";
        
        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        return array_map(function ($row) {
            $dataIso = DateFormatter::toIsoDate($row['data'] ?? null);
            
            $dto = new VariavelDTO(
                registroId: RowMapper::toString($row['registro_id'] ?? null),
                idIndicador: null,
                dsIndicador: null,
                familiaId: null,
                familiaNome: null,
                familiaCodigo: null,
                indicadorCodigo: null,
                subindicadorCodigo: null,
                data: $dataIso,
                competencia: $dataIso,
                variavelReal: RowMapper::toFloat($row['variavel_real'] ?? null),
                variavelMeta: RowMapper::toFloat($row['variavel_meta'] ?? null),
            );
            
            return $dto->toArray();
        }, $results);
    }
}

