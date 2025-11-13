<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

class MetaRepository implements RepositoryInterface
{
    private EntityManager $entityManager;
    private Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $entityManager->getConnection();
    }

    public function sumByPeriodAndFilters(
        string $dateFrom,
        string $dateTo,
        array $filters = [],
        array $bindValues = [],
        ?string $indicadorId = null
    ): float {
        $bind = array_merge([
            'ini' => $dateFrom,
            'fim' => $dateTo,
        ], $bindValues);

        $where = $filters ? ' AND ' . implode(' AND ', $filters) : '';

        $indicadorFilter = '';
        if ($indicadorId !== null && $indicadorId !== '') {
            $bind['id_indicador'] = $indicadorId;
            $indicadorFilter = ' AND m.id_indicador = :id_indicador';
        }

        $sql = "SELECT SUM(m.meta_mensal) AS total_meta
                FROM f_metas m
                JOIN d_calendario c ON c.data = m.data
                JOIN d_unidades u ON u.segmento_id = m.segmento_id 
                    AND u.diretoria_id = m.diretoria_id 
                    AND u.gerencia_regional_id = m.gerencia_regional_id 
                    AND u.agencia_id = m.agencia_id
                WHERE c.data BETWEEN :ini AND :fim{$indicadorFilter}{$where}";

        $result = $this->connection->executeQuery($sql, $bind)->fetchAssociative();

        return (float) ($result['total_meta'] ?? 0);
    }
}
