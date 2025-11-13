<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;

class EstruturaRepository implements RepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllSegmentos(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_segmento AS id, segmento AS nome
             FROM d_estrutura
             WHERE id_segmento IS NOT NULL AND segmento IS NOT NULL
             ORDER BY nome'
        );
    }

    public function findAllDiretorias(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_diretoria AS id, diretoria AS nome
             FROM d_estrutura
             WHERE id_diretoria IS NOT NULL AND diretoria IS NOT NULL
             ORDER BY nome'
        );
    }

    public function findAllRegionais(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_regional AS id, regional AS nome
             FROM d_estrutura
             WHERE id_regional IS NOT NULL AND regional IS NOT NULL
             ORDER BY nome'
        );
    }

    public function findAllAgencias(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_agencia AS id, agencia AS nome, porte
             FROM d_estrutura
             WHERE id_agencia IS NOT NULL AND agencia IS NOT NULL
             ORDER BY nome'
        );
    }

    public function findAllGGestoes(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            "SELECT DISTINCT funcional AS id, nome
             FROM d_estrutura
             WHERE cargo LIKE 'Gerente de Gestao%' OR cargo LIKE 'Gerente de Gestão%'
             ORDER BY nome"
        );
    }

    public function findAllGerentes(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            "SELECT DISTINCT funcional AS id, nome
             FROM d_estrutura
             WHERE cargo LIKE 'Gerente%' AND cargo NOT LIKE 'Gerente de Gest%'
             ORDER BY nome"
        );
    }

    public function findSegmentosForFilter(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_segmento AS id, segmento AS label
             FROM d_estrutura
             WHERE id_segmento IS NOT NULL AND segmento IS NOT NULL
             ORDER BY label'
        );
    }

    public function findDiretoriasForFilter(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_diretoria AS id, diretoria AS label
             FROM d_estrutura
             WHERE id_diretoria IS NOT NULL AND diretoria IS NOT NULL
             ORDER BY label'
        );
    }

    public function findRegionaisForFilter(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_regional AS id, regional AS label
             FROM d_estrutura
             WHERE id_regional IS NOT NULL AND regional IS NOT NULL
             ORDER BY label'
        );
    }

    public function findAgenciasForFilter(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_agencia AS id, agencia AS label, porte
             FROM d_estrutura
             WHERE id_agencia IS NOT NULL AND agencia IS NOT NULL
             ORDER BY label'
        );
    }

    public function findGGestoesForFilter(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            "SELECT DISTINCT funcional AS id, nome AS label
             FROM d_estrutura
             WHERE cargo LIKE 'Gerente de Gestao%' OR cargo LIKE 'Gerente de Gestão%'
             ORDER BY label"
        );
    }

    public function findGerentesForFilter(): array
    {
        return DatabaseConnection::query(
            $this->pdo,
            "SELECT DISTINCT funcional AS id, nome AS label
             FROM d_estrutura
             WHERE cargo LIKE 'Gerente%' AND cargo NOT LIKE 'Gerente de Gest%'
             ORDER BY label"
        );
    }
}

