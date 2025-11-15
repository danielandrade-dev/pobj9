<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\MetaDTO;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Helpers\RowMapper;
use Pobj\Api\Interfaces\RepositoryInterface;

class MetaRepository implements RepositoryInterface
{
    private Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function sumByPeriodAndFilters(
        string $dateFrom,
        string $dateTo,
        array $filters = [],
        array $bindValues = [],
        ?string $indicadorId = null
    ): float {
        $bind = array_merge(['ini' => $dateFrom, 'fim' => $dateTo], $bindValues);
        $where = $filters ? ' AND ' . implode(' AND ', $filters) : '';
        $indicadorFilter = '';

        if ($indicadorId !== null && $indicadorId !== '' && is_numeric($indicadorId)) {
            $bind['indicador_id'] = (int)$indicadorId;
            $indicadorFilter = ' AND m.id_indicador = :indicador_id';
        }

        $sql = "SELECT SUM(m.meta_mensal) AS total_meta
                FROM f_meta m
                JOIN d_calendario c ON c.data = m.data_meta
                WHERE c.data BETWEEN :ini AND :fim{$indicadorFilter}{$where}";

        $result = $this->connection->executeQuery($sql, $bind)->fetchAssociative();
        return (float) ($result['total_meta'] ?? 0);
    }

    public function findAllAsArray(): array
    {
        $sql = "SELECT 
                    m.id AS registro_id,
                    m.data_meta AS data,
                    m.data_meta AS competencia,
                    m.funcional,
                    m.meta_mensal,
                    m.id_familia AS familia_id,
                    m.id_indicador AS indicador_id,
                    m.id_subindicador AS subindicador_id,
                    m.segmento_id,
                    m.diretoria_id,
                    m.gerencia_regional_id,
                    m.agencia_id,
                    COALESCE(u.segmento_label, '') AS segmento,
                    COALESCE(u.diretoria_label, '') AS diretoria_nome,
                    COALESCE(u.regional_label, '') AS gerencia_regional_nome,
                    COALESCE(u.regional_label, '') AS regional_nome,
                    COALESCE(u.agencia_label, '') AS agencia_nome,
                    COALESCE(u.gerente_gestao_id, '') AS gerente_gestao_id,
                    COALESCE(u.gerente_gestao, '') AS gerente_gestao_nome,
                    COALESCE(u.gerente_id, '') AS gerente_id,
                    COALESCE(u.gerente, '') AS gerente_nome,
                    COALESCE(p.familia, '') AS familia_nome,
                    COALESCE(CAST(p.id_indicador AS CHAR), '') AS id_indicador,
                    COALESCE(p.indicador, '') AS ds_indicador,
                    COALESCE(p.subindicador, '') AS subproduto,
                    COALESCE(CAST(p.id_subindicador AS CHAR), '0') AS id_subindicador
                FROM f_meta m
                LEFT JOIN d_unidade u ON u.segmento_id = m.segmento_id
                    AND u.diretoria_id = m.diretoria_id
                    AND u.regional_id = m.gerencia_regional_id
                    AND u.agencia_id = m.agencia_id
                LEFT JOIN d_produtos p ON p.id_indicador = m.id_indicador
                    AND (p.id_subindicador = m.id_subindicador OR (p.id_subindicador IS NULL AND m.id_subindicador IS NULL))
                ORDER BY m.data_meta DESC, m.id";
        
        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        return array_map(function ($row) {
            $dataIso = DateFormatter::toIsoDate($row['data'] ?? null);
            
            $dto = new MetaDTO(
                registroId: RowMapper::toString($row['registro_id'] ?? null),
                segmento: $row['segmento'] ?? null,
                segmentoId: RowMapper::toString($row['segmento_id'] ?? null),
                diretoriaId: RowMapper::toString($row['diretoria_id'] ?? null),
                diretoriaNome: $row['diretoria_nome'] ?? null,
                gerenciaId: RowMapper::toString($row['gerencia_regional_id'] ?? null),
                gerenciaNome: $row['gerencia_regional_nome'] ?? null,
                regionalNome: $row['regional_nome'] ?? null,
                agenciaId: RowMapper::toString($row['agencia_id'] ?? null),
                agenciaNome: $row['agencia_nome'] ?? null,
                gerenteGestaoId: $row['gerente_gestao_id'] ?? null,
                gerenteGestaoNome: $row['gerente_gestao_nome'] ?? null,
                gerenteId: $row['gerente_id'] ?? null,
                gerenteNome: $row['gerente_nome'] ?? null,
                familiaId: RowMapper::toString($row['familia_id'] ?? null),
                familiaNome: $row['familia_nome'] ?? null,
                idIndicador: $row['id_indicador'] ?? null,
                dsIndicador: $row['ds_indicador'] ?? null,
                subproduto: $row['subproduto'] ?? null,
                subindicadorCodigo: $row['id_subindicador'] ?? null,
                familiaCodigo: RowMapper::toString($row['familia_id'] ?? null),
                indicadorCodigo: RowMapper::toString($row['indicador_id'] ?? null),
                carteira: null,
                canalVenda: null,
                tipoVenda: null,
                modalidadePagamento: null,
                data: $dataIso,
                competencia: $dataIso,
                metaMensal: RowMapper::toFloat($row['meta_mensal'] ?? null),
                metaAcumulada: null,
                variavelMeta: null,
                peso: null,
            );
            
            return $dto->toArray();
        }, $results);
    }
}
