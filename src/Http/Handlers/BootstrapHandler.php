<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Handlers;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Response\ResponseHelper;

/**
 * Handler para endpoint bootstrap
 */
class BootstrapHandler
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retorna todos os dados necessários para inicialização do frontend
     *
     * @return void
     */
    public function handle(): void
    {
        $payload = [];
        $payload['segmentos'] = DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_segmento AS id, segmento AS nome
             FROM d_estrutura
             WHERE id_segmento IS NOT NULL AND segmento IS NOT NULL
             ORDER BY nome'
        );
        $payload['diretorias'] = DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_diretoria AS id, diretoria AS nome
             FROM d_estrutura
             WHERE id_diretoria IS NOT NULL AND diretoria IS NOT NULL
             ORDER BY nome'
        );
        $payload['regionais'] = DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_regional AS id, regional AS nome
             FROM d_estrutura
             WHERE id_regional IS NOT NULL AND regional IS NOT NULL
             ORDER BY nome'
        );
        $payload['agencias'] = DatabaseConnection::query(
            $this->pdo,
            'SELECT DISTINCT id_agencia AS id, agencia AS nome, porte
             FROM d_estrutura
             WHERE id_agencia IS NOT NULL AND agencia IS NOT NULL
             ORDER BY nome'
        );
        $payload['ggestoes'] = DatabaseConnection::query(
            $this->pdo,
            "SELECT DISTINCT funcional AS id, nome
             FROM d_estrutura
             WHERE cargo LIKE 'Gerente de Gestao%' OR cargo LIKE 'Gerente de Gestão%'
             ORDER BY nome"
        );
        $payload['gerentes'] = DatabaseConnection::query(
            $this->pdo,
            "SELECT DISTINCT funcional AS id, nome
             FROM d_estrutura
             WHERE cargo LIKE 'Gerente%' AND cargo NOT LIKE 'Gerente de Gest%'
             ORDER BY nome"
        );
        $payload['statusIndicadores'] = DatabaseConnection::query(
            $this->pdo,
            'SELECT id, status FROM d_status_indicadores ORDER BY id'
        );

        ResponseHelper::json($payload);
    }
}

