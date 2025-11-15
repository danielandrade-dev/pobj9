<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\LeadsDTO;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Helpers\RowMapper;
use Pobj\Api\Interfaces\RepositoryInterface;

class LeadsRepository implements RepositoryInterface
{
    private Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function findAllAsArray(): array
    {
        $sql = "SELECT 
                    `database` AS data,
                    nome_empresa,
                    cnae,
                    segmento_cliente,
                    segmento_cliente_id,
                    produto_propenso,
                    familia_produto_propenso,
                    secao_produto_propenso,
                    id_indicador,
                    id_subindicador,
                    data_contato,
                    comentario,
                    responsavel_contato,
                    diretoria_cliente,
                    diretoria_cliente_id,
                    regional_cliente,
                    regional_cliente_id,
                    agencia_cliente,
                    agencia_cliente_id,
                    gerente_gestao_cliente,
                    gerente_gestao_cliente_id,
                    gerente_cliente,
                    gerente_cliente_id,
                    credito_pre_aprovado,
                    origem_lead
                FROM f_leads_propensos
                ORDER BY `database` DESC, nome_empresa";
        
        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        return array_map(function ($row) {
            $dataIso = DateFormatter::toIsoDate($row['data'] ?? null);
            $dataContatoIso = DateFormatter::toIsoDate($row['data_contato'] ?? null);
            $registroId = $dataIso . '_' . ($row['nome_empresa'] ?? '');
            
            $dto = new LeadsDTO(
                registroId: $registroId,
                data: $dataIso,
                competencia: $dataIso,
                nomeEmpresa: $row['nome_empresa'] ?? null,
                cnae: $row['cnae'] ?? null,
                segmento: $row['segmento_cliente'] ?? null,
                segmentoId: $row['segmento_cliente_id'] ?? null,
                produtoPropenso: $row['produto_propenso'] ?? null,
                familiaNome: $row['familia_produto_propenso'] ?? null,
                subproduto: $row['secao_produto_propenso'] ?? null,
                idIndicador: $row['id_indicador'] ?? null,
                subindicadorCodigo: $row['id_subindicador'] ?? null,
                dataContato: $dataContatoIso,
                comentario: $row['comentario'] ?? null,
                responsavelContato: $row['responsavel_contato'] ?? null,
                diretoriaNome: $row['diretoria_cliente'] ?? null,
                diretoriaId: $row['diretoria_cliente_id'] ?? null,
                regionalNome: $row['regional_cliente'] ?? null,
                gerenciaId: $row['regional_cliente_id'] ?? null,
                agenciaNome: $row['agencia_cliente'] ?? null,
                agenciaId: $row['agencia_cliente_id'] ?? null,
                gerenteGestaoNome: $row['gerente_gestao_cliente'] ?? null,
                gerenteGestaoId: $row['gerente_gestao_cliente_id'] ?? null,
                gerenteNome: $row['gerente_cliente'] ?? null,
                gerenteId: $row['gerente_cliente_id'] ?? null,
                creditoPreAprovado: RowMapper::toString($row['credito_pre_aprovado'] ?? null),
                origemLead: $row['origem_lead'] ?? null,
            );
            
            return $dto->toArray();
        }, $results);
    }
}

