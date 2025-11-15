<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\HistoricoDTO;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Helpers\RowMapper;
use Pobj\Api\Interfaces\RepositoryInterface;

class HistoricoRepository implements RepositoryInterface
{
    private Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function findAllAsArray(): array
    {
        $sql = "SELECT 
                    nivel,
                    ano,
                    `database` AS data,
                    segmento,
                    segmento_id,
                    diretoria,
                    diretoria_nome,
                    gerencia_regional,
                    gerencia_regional_nome,
                    agencia,
                    agencia_nome,
                    gerente_gestao,
                    gerente_gestao_nome,
                    gerente,
                    gerente_nome,
                    participantes,
                    `rank`,
                    pontos,
                    realizado,
                    meta
                FROM f_historico_ranking_pobj
                ORDER BY `database` DESC, nivel, ano";
        
        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        return array_map(function ($row) {
            $dataIso = DateFormatter::toIsoDate($row['data'] ?? null);
            
            $dto = new HistoricoDTO(
                nivel: $row['nivel'] ?? null,
                ano: $row['ano'] ?? null,
                data: $dataIso,
                competencia: $dataIso,
                segmento: $row['segmento'] ?? null,
                segmentoId: $row['segmento_id'] ?? null,
                diretoriaId: $row['diretoria'] ?? null,
                diretoriaNome: $row['diretoria_nome'] ?? null,
                gerenciaId: $row['gerencia_regional'] ?? null,
                gerenciaNome: $row['gerencia_regional_nome'] ?? null,
                agenciaId: $row['agencia'] ?? null,
                agenciaNome: $row['agencia_nome'] ?? null,
                gerenteGestaoId: $row['gerente_gestao'] ?? null,
                gerenteGestaoNome: $row['gerente_gestao_nome'] ?? null,
                gerenteId: $row['gerente'] ?? null,
                gerenteNome: $row['gerente_nome'] ?? null,
                participantes: $row['participantes'] ?? null,
                rank: $row['rank'] ?? null,
                pontos: RowMapper::toFloat($row['pontos'] ?? null),
                realizadoMensal: RowMapper::toFloat($row['realizado'] ?? null),
                metaMensal: RowMapper::toFloat($row['meta'] ?? null),
            );
            
            return $dto->toArray();
        }, $results);
    }
}

