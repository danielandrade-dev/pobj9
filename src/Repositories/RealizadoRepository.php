<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;

class RealizadoRepository implements RepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function sumByPeriodAndFilters(
        string $dateFrom,
        string $dateTo,
        array $filters = [],
        array $bindValues = [],
        ?string $indicadorId = null
    ): float {
        $bind = array_merge([
            ':ini' => $dateFrom,
            ':fim' => $dateTo,
        ], $bindValues);

        $where = $filters ? ' AND ' . implode(' AND ', $filters) : '';

        $indicadorFilter = '';
        if ($indicadorId !== null && $indicadorId !== '') {
            $bind[':id_indicador'] = $indicadorId;
            $indicadorFilter = ' AND r.id_indicador = :id_indicador';
        }

        $result = DatabaseConnection::query(
            $this->pdo,
            "SELECT SUM(r.realizado) AS total_realizado
             FROM f_realizado r
             JOIN d_calendario c ON c.data = r.data_realizado
             JOIN d_estrutura e ON e.funcional = r.funcional
             WHERE c.data BETWEEN :ini AND :fim{$indicadorFilter}{$where}",
            $bind
        );

        return (float) ($result[0]['total_realizado'] ?? 0);
    }
}
