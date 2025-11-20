<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\RealizadoDTO;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Helpers\RowMapper;
use Pobj\Api\Interfaces\RepositoryInterface;

class RealizadoRepository implements RepositoryInterface
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
            $indicadorFilter = ' AND r.indicador_id = :indicador_id';
        }

        $sql = "SELECT SUM(r.realizado) AS total_realizado
                FROM f_realizados r
                JOIN d_calendario c ON c.data = r.data_realizado
                WHERE c.data BETWEEN :ini AND :fim{$indicadorFilter}{$where}";

        $result = $this->connection->executeQuery($sql, $bind)->fetchAssociative();
        return (float) ($result['total_realizado'] ?? 0);
    }

    public function findAllAsArray(): array
    {
        $sql = "SELECT 
                    r.id AS registro_id,
                    r.id_contrato,
                    r.data_realizado AS data,
                    r.data_realizado AS competencia,
                    r.funcional,
                    r.realizado AS realizado_mensal,
                    r.familia_id,
                    r.indicador_id,
                    r.subindicador_id,
                    r.segmento_id,
                    r.diretoria_id,
                    r.gerencia_regional_id,
                    r.agencia_id,
                    COALESCE(u.segmento, '') AS segmento,
                    COALESCE(u.diretoria, '') AS diretoria_nome,
                    COALESCE(u.regional, '') AS gerencia_regional_nome,
                    COALESCE(u.regional, '') AS regional_nome,
                    COALESCE(u.agencia, '') AS agencia_nome,
                    COALESCE(u.funcional, '') AS gerente_gestao_id,
                    COALESCE(u.nome, '') AS gerente_gestao_nome,
                    COALESCE(u.funcional, '') AS gerente_id,
                    COALESCE(u.nome, '') AS gerente_nome,
                    COALESCE(p.familia, '') AS familia_nome,
                    COALESCE(CAST(p.id_indicador AS CHAR), '') AS id_indicador,
                    COALESCE(p.indicador, '') AS ds_indicador,
                    COALESCE(p.subindicador, '') AS subproduto,
                    COALESCE(CAST(COALESCE(p.id_subindicador, 0) AS CHAR), '0') AS id_subindicador
                FROM f_realizados r
                LEFT JOIN d_estrutura u ON u.id_segmento = r.segmento_id
                    AND u.id_diretoria = r.diretoria_id
                    AND u.id_regional = r.gerencia_regional_id
                    AND u.id_agencia = r.agencia_id
                LEFT JOIN d_produtos p ON p.id_indicador = r.indicador_id
                    AND (p.id_subindicador = r.subindicador_id OR (p.id_subindicador IS NULL AND r.subindicador_id IS NULL))
                ORDER BY r.data_realizado DESC, r.id";
        
        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        return array_map(function ($row) {
            $dataIso = DateFormatter::toIsoDate($row['data'] ?? null);
            $competenciaIso = DateFormatter::toIsoDate($row['competencia'] ?? null);
            
            $dto = new RealizadoDTO(
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
                competencia: $competenciaIso,
                realizadoMensal: RowMapper::toFloat($row['realizado_mensal'] ?? null),
                realizadoAcumulado: null,
                quantidade: RowMapper::toFloat($row['quantidade'] ?? null),
                variavelReal: RowMapper::toFloat($row['variavel_real'] ?? null),
            );
            
            return $dto->toArray();
        }, $results);
    }
}
