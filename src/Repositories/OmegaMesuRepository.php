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
                    segmento AS Segmento,
                    segmento_id AS 'Id Segmento',
                    diretoria_regional AS Diretoria,
                    diretoria_id AS 'ID Diretoria',
                    gerencia_regional AS 'Gerencia Regional',
                    gerencia_regional_id AS 'Id Gerencia Regional',
                    agencia AS Agencia,
                    agencia_id AS 'Id Agencia',
                    gerente_gestao AS 'Gerente de Gestao',
                    gerente_gestao_id AS 'Id Gerente de Gestao',
                    gerente AS Gerente,
                    gerente_id AS 'Id Gerente'
                FROM d_unidades
                WHERE segmento IS NOT NULL
                ORDER BY segmento, diretoria_regional, gerencia_regional, agencia";

        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }
}

