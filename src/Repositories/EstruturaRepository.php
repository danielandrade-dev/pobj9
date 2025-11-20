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
        return $this->findSegmentos('nome');
    }

    public function findAllDiretorias(): array
    {
        return $this->findDiretorias('nome');
    }

    public function findAllRegionais(): array
    {
        return $this->findRegionais('nome');
    }

    public function findAllAgencias(): array
    {
        return $this->findAgencias('nome');
    }

    public function findAllGGestoes(): array
    {
        return $this->findGGestoes('nome', true);
    }

    public function findAllGerentes(): array
    {
        return $this->findGerentes('nome', true);
    }

    public function findSegmentosForFilter(): array
    {
        return $this->findSegmentos('label');
    }

    public function findDiretoriasForFilter(): array
    {
        return $this->findDiretorias('label');
    }

    public function findRegionaisForFilter(): array
    {
        return $this->findRegionais('label');
    }

    public function findAgenciasForFilter(): array
    {
        return $this->findAgencias('label');
    }

    public function findGGestoesForFilter(): array
    {
        return $this->findGGestoes('label', false);
    }

    public function findGerentesForFilter(): array
    {
        return $this->findGerentes('label', false);
    }

    private function findSegmentos(string $alias): array
    {
        $alias = $this->validateAlias($alias);
        $sql = "SELECT DISTINCT id_segmento AS id, segmento AS {$alias}
                FROM d_estrutura
                WHERE id_segmento IS NOT NULL AND segmento IS NOT NULL
                ORDER BY {$alias}";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    private function findDiretorias(string $alias): array
    {
        $alias = $this->validateAlias($alias);
        $sql = "SELECT DISTINCT id_diretoria AS id, diretoria AS {$alias}
                FROM d_estrutura 
                WHERE id_diretoria IS NOT NULL AND diretoria IS NOT NULL
                ORDER BY {$alias}";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    private function findRegionais(string $alias): array
    {
        $alias = $this->validateAlias($alias);
        $sql = "SELECT DISTINCT id_regional AS id, regional AS {$alias}
                FROM d_estrutura
                WHERE id_regional IS NOT NULL AND regional IS NOT NULL
                ORDER BY {$alias}";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    private function findAgencias(string $alias): array
    {
        $alias = $this->validateAlias($alias);
        $sql = "SELECT DISTINCT id_agencia AS id, agencia AS {$alias}, porte
                FROM d_estrutura
                WHERE id_agencia IS NOT NULL AND agencia IS NOT NULL
                ORDER BY {$alias}";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    private function findGGestoes(string $alias, bool $checkEmptyStrings): array
    {
        $alias = $this->validateAlias($alias);
        $emptyCheck = $checkEmptyStrings 
            ? "AND funcional != '' AND nome != ''" 
            : '';
        
        $sql = "SELECT DISTINCT funcional AS id, nome AS {$alias}
                FROM d_estrutura
                WHERE cargo = 'Gerente de Gestão'
                    AND funcional IS NOT NULL 
                    AND nome IS NOT NULL
                    {$emptyCheck}
                ORDER BY {$alias}";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    private function findGerentes(string $alias, bool $checkEmptyStrings): array
    {
        $alias = $this->validateAlias($alias);
        $emptyCheck = $checkEmptyStrings 
            ? "AND funcional != '' AND nome != ''" 
            : '';
        
        $sql = "SELECT DISTINCT funcional AS id, nome AS {$alias}
                FROM d_estrutura
                WHERE cargo = 'Gerente'
                    AND funcional IS NOT NULL 
                    AND nome IS NOT NULL
                    {$emptyCheck}
                ORDER BY {$alias}";
        
        return $this->connection->executeQuery($sql)->fetchAllAssociative();
    }

    private function validateAlias(string $alias): string
    {
        return in_array($alias, ['nome', 'label'], true) ? $alias : 'nome';
    }
}

