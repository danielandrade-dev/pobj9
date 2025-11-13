<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

class EstruturaRepository implements RepositoryInterface
{
    private EntityManager $entityManager;
    private Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $entityManager->getConnection();
    }

    public function findAllSegmentos(): array
    {
        $sql = 'SELECT DISTINCT segmento_id AS id, segmento AS nome
                FROM d_unidades
                WHERE segmento_id IS NOT NULL AND segmento IS NOT NULL
                ORDER BY nome';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllDiretorias(): array
    {
        $sql = 'SELECT DISTINCT diretoria_id AS id, diretoria_regional AS nome
                FROM d_unidades
                WHERE diretoria_id IS NOT NULL AND diretoria_regional IS NOT NULL
                ORDER BY nome';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllRegionais(): array
    {
        $sql = 'SELECT DISTINCT gerencia_regional_id AS id, gerencia_regional AS nome
                FROM d_unidades
                WHERE gerencia_regional_id IS NOT NULL AND gerencia_regional IS NOT NULL
                ORDER BY nome';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllAgencias(): array
    {
        $sql = 'SELECT DISTINCT agencia_id AS id, agencia AS nome, NULL AS porte
                FROM d_unidades
                WHERE agencia_id IS NOT NULL AND agencia IS NOT NULL
                ORDER BY nome';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllGGestoes(): array
    {
        $sql = "SELECT DISTINCT gerente_gestao_id AS id, gerente_gestao AS nome
                FROM d_unidades
                WHERE gerente_gestao_id IS NOT NULL AND gerente_gestao IS NOT NULL
                ORDER BY nome";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllGerentes(): array
    {
        $sql = "SELECT DISTINCT gerente_id AS id, gerente AS nome
                FROM d_unidades
                WHERE gerente_id IS NOT NULL AND gerente IS NOT NULL
                ORDER BY nome";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findSegmentosForFilter(): array
    {
        $sql = 'SELECT DISTINCT segmento_id AS id, segmento AS label
                FROM d_unidades
                WHERE segmento_id IS NOT NULL AND segmento IS NOT NULL
                ORDER BY label';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findDiretoriasForFilter(): array
    {
        $sql = 'SELECT DISTINCT diretoria_id AS id, diretoria_regional AS label
                FROM d_unidades
                WHERE diretoria_id IS NOT NULL AND diretoria_regional IS NOT NULL
                ORDER BY label';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findRegionaisForFilter(): array
    {
        $sql = 'SELECT DISTINCT gerencia_regional_id AS id, gerencia_regional AS label
                FROM d_unidades
                WHERE gerencia_regional_id IS NOT NULL AND gerencia_regional IS NOT NULL
                ORDER BY label';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAgenciasForFilter(): array
    {
        $sql = 'SELECT DISTINCT agencia_id AS id, agencia AS label, NULL AS porte
                FROM d_unidades
                WHERE agencia_id IS NOT NULL AND agencia IS NOT NULL
                ORDER BY label';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findGGestoesForFilter(): array
    {
        $sql = "SELECT DISTINCT gerente_gestao_id AS id, gerente_gestao AS label
                FROM d_unidades
                WHERE gerente_gestao_id IS NOT NULL AND gerente_gestao IS NOT NULL
                ORDER BY label";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findGerentesForFilter(): array
    {
        $sql = "SELECT DISTINCT gerente_id AS id, gerente AS label
                FROM d_unidades
                WHERE gerente_id IS NOT NULL AND gerente IS NOT NULL
                ORDER BY label";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }
}

