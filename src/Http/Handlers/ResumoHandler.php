<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Handlers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Response\ResponseHelper;

/**
 * Handler para endpoint resumo
 */
class ResumoHandler
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Processa requisição de resumo com filtros
     *
     * @param array<string, string> $params
     */
    public function handle(array $params): void
    {
        $seg = trim($params['segmento_id'] ?? '');
        $dir = trim($params['diretoria_id'] ?? '');
        $reg = trim($params['regional_id'] ?? '');
        $age = trim($params['agencia_id'] ?? '');
        $gg  = trim($params['gg_funcional'] ?? '');
        $ger = trim($params['gerente_funcional'] ?? '');
        $ini = trim($params['data_ini'] ?? '');
        $fim = trim($params['data_fim'] ?? '');
        $indicador = trim($params['id_indicador'] ?? '');

        if ($ini === '' || $fim === '') {
            ResponseHelper::error('data_ini/data_fim obrigatórios');
        }

        $filters = [];
        $bind = [
            ':ini' => $ini,
            ':fim' => $fim,
        ];

        if ($seg !== '') {
            $filters[] = 'e.id_segmento = :segmento_id';
            $bind[':segmento_id'] = $seg;
        }
        if ($dir !== '') {
            $filters[] = 'e.id_diretoria = :diretoria_id';
            $bind[':diretoria_id'] = $dir;
        }
        if ($reg !== '') {
            $filters[] = 'e.id_regional = :regional_id';
            $bind[':regional_id'] = $reg;
        }
        if ($age !== '') {
            $filters[] = 'e.id_agencia = :agencia_id';
            $bind[':agencia_id'] = $age;
        }
        if ($gg !== '') {
            $filters[] = 'e.funcional = :gg_funcional';
            $bind[':gg_funcional'] = $gg;
        }
        if ($ger !== '') {
            $filters[] = 'e.funcional = :gerente_funcional';
            $bind[':gerente_funcional'] = $ger;
        }

        $where = $filters ? ' AND ' . implode(' AND ', $filters) : '';

        $indicadorFilterReal = '';
        $indicadorFilterMeta = '';
        if ($indicador !== '') {
            $bind[':id_indicador'] = $indicador;
            $indicadorFilterReal = ' AND r.id_indicador = :id_indicador';
            $indicadorFilterMeta = ' AND m.id_indicador = :id_indicador';
        }

        $real = DatabaseConnection::query(
            $this->pdo,
            "SELECT SUM(r.realizado) AS total_realizado
             FROM f_realizado r
             JOIN d_calendario c ON c.data = r.data_realizado
             JOIN d_estrutura e ON e.funcional = r.funcional
             WHERE c.data BETWEEN :ini AND :fim{$indicadorFilterReal}{$where}",
            $bind
        );

        $meta = DatabaseConnection::query(
            $this->pdo,
            "SELECT SUM(m.meta_mensal) AS total_meta
             FROM f_meta m
             JOIN d_calendario c ON c.data = m.data_meta
             JOIN d_estrutura e ON e.funcional = m.funcional
             WHERE c.data BETWEEN :ini AND :fim{$indicadorFilterMeta}{$where}",
            $bind
        );

        ResponseHelper::json([
            'realizado_total' => (float) ($real[0]['total_realizado'] ?? 0),
            'meta_total' => (float) ($meta[0]['total_meta'] ?? 0),
        ]);
    }
}

