<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Handlers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Response\ResponseHelper;

class FiltrosHandler
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function handle(string $nivel): void
    {
        switch ($nivel) {
            case 'segmentos':
                $this->getSegmentos();
                break;
            case 'diretorias':
                $this->getDiretorias();
                break;
            case 'regionais':
                $this->getRegionais();
                break;
            case 'agencias':
                $this->getAgencias();
                break;
            case 'ggestoes':
                $this->getGGestoes();
                break;
            case 'gerentes':
                $this->getGerentes();
                break;
            case 'status_indicadores':
                $this->getStatusIndicadores();
                break;
            default:
                ResponseHelper::error('nivel inválido');
        }
    }

    private function getSegmentos(): void
    {
        $result = DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_segmento AS id, segmento AS label
             FROM d_estrutura
             WHERE id_segmento IS NOT NULL AND segmento IS NOT NULL
             ORDER BY label'
        );
        ResponseHelper::json($result);
    }

    private function getDiretorias(): void
    {
        $result = DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_diretoria AS id, diretoria AS label
             FROM d_estrutura
             WHERE id_diretoria IS NOT NULL AND diretoria IS NOT NULL
             ORDER BY label'
        );
        ResponseHelper::json($result);
    }

    private function getRegionais(): void
    {
        $result = DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_regional AS id, regional AS label
             FROM d_estrutura
             WHERE id_regional IS NOT NULL AND regional IS NOT NULL
             ORDER BY label'
        );
        ResponseHelper::json($result);
    }

    private function getAgencias(): void
    {
        $result = DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_agencia AS id, agencia AS label, porte
             FROM d_estrutura
             WHERE id_agencia IS NOT NULL AND agencia IS NOT NULL
             ORDER BY label'
        );
        ResponseHelper::json($result);
    }

    private function getGGestoes(): void
    {
        $result = DatabaseConnection::query(
            $this->pdo,
            "SELECT DISTINCT funcional AS id, nome AS label
             FROM d_estrutura
             WHERE cargo LIKE 'Gerente de Gestao%' OR cargo LIKE 'Gerente de Gestão%'
             ORDER BY label"
        );
        ResponseHelper::json($result);
    }

    private function getGerentes(): void
    {
        $result = DatabaseConnection::query(
            $this->pdo,
            "SELECT DISTINCT funcional AS id, nome AS label
             FROM d_estrutura
             WHERE cargo LIKE 'Gerente%' AND cargo NOT LIKE 'Gerente de Gest%'
             ORDER BY label"
        );
        ResponseHelper::json($result);
    }

    private function getStatusIndicadores(): void
    {
        $rows = DatabaseConnection::query(
            $this->pdo,
            'SELECT id, status AS label FROM d_status_indicadores ORDER BY id'
        );
        if (!$rows) {
            $rows = [
                ['id' => '01', 'label' => 'Atingido'],
                ['id' => '02', 'label' => 'Não Atingido'],
                ['id' => '03', 'label' => 'Todos'],
            ];
        }
        ResponseHelper::json($rows);
    }
}
