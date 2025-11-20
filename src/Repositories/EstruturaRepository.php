<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\Interfaces\RepositoryInterface;

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
        $sql = 'SELECT DISTINCT id_segmento AS id, segmento AS nome
                FROM d_estrutura
                WHERE id_segmento IS NOT NULL AND segmento IS NOT NULL
                ORDER BY nome';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllDiretorias(): array
    {
        $sql = 'SELECT DISTINCT id_diretoria AS id, diretoria AS nome
                FROM d_estrutura 
                WHERE id_diretoria IS NOT NULL AND diretoria IS NOT NULL
                ORDER BY nome';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllRegionais(): array
    {
        $sql = 'SELECT DISTINCT id_regional AS id, regional AS nome
                FROM d_estrutura
                WHERE id_regional IS NOT NULL AND regional IS NOT NULL
                ORDER BY nome';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllAgencias(): array
    {
        $sql = 'SELECT DISTINCT id_agencia AS id, agencia AS nome, porte
                FROM d_estrutura
                WHERE id_agencia IS NOT NULL AND agencia IS NOT NULL
                ORDER BY nome';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllGGestoes(): array
    {
        $sql = "SELECT DISTINCT funcional AS id, nome AS nome
                FROM d_estrutura
                WHERE cargo LIKE '%Gerente Gestão%'
                    AND funcional IS NOT NULL 
                    AND funcional != ''
                    AND nome IS NOT NULL
                    AND nome != ''
                ORDER BY nome";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAllGerentes(): array
    {
        $sql = "SELECT DISTINCT funcional AS id, nome AS nome
                FROM d_estrutura
                WHERE cargo LIKE '%Gerente%'
                    AND funcional IS NOT NULL 
                    AND funcional != ''
                    AND nome IS NOT NULL
                    AND nome != ''
                ORDER BY nome";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findSegmentosForFilter(): array
    {
        $sql = 'SELECT DISTINCT id_segmento AS id, segmento AS label
                FROM d_estrutura
                WHERE id_segmento IS NOT NULL AND segmento IS NOT NULL
                ORDER BY label';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findDiretoriasForFilter(): array
    {
        $sql = 'SELECT DISTINCT id_diretoria AS id, diretoria AS label
                FROM d_estrutura
                WHERE id_diretoria IS NOT NULL AND diretoria IS NOT NULL
                ORDER BY label';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findRegionaisForFilter(): array
    {
        $sql = 'SELECT DISTINCT id_regional AS id, regional AS label
                FROM d_estrutura
                WHERE id_regional IS NOT NULL AND regional IS NOT NULL
                ORDER BY label';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findAgenciasForFilter(): array
    {
        $sql = 'SELECT DISTINCT id_agencia AS id, agencia AS label, porte
                FROM d_estrutura
                WHERE id_agencia IS NOT NULL AND agencia IS NOT NULL
                ORDER BY label';
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findGGestoesForFilter(): array
    {
        $sql = "SELECT DISTINCT funcional AS id, nome AS label
                FROM d_estrutura
                WHERE cargo LIKE '%Gerente Gestão%'
                    AND funcional IS NOT NULL AND nome IS NOT NULL
                ORDER BY label";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    public function findGerentesForFilter(): array
    {
        $sql = "SELECT DISTINCT funcional AS id, nome AS label
                FROM d_estrutura
                WHERE cargo LIKE '%Gerente%'
                    AND funcional IS NOT NULL AND nome IS NOT NULL
                ORDER BY label";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }
}

