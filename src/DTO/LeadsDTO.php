<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class LeadsDTO extends BaseFactDTO
{
    public function __construct(
        public readonly ?string $registroId = null,
        public readonly ?string $data = null,
        public readonly ?string $competencia = null,
        public readonly ?string $nomeEmpresa = null,
        public readonly ?string $cnae = null,
        public readonly ?string $segmento = null,
        public readonly ?string $segmentoId = null,
        public readonly ?string $produtoPropenso = null,
        public readonly ?string $familiaNome = null,
        public readonly ?string $subproduto = null,
        public readonly ?string $idIndicador = null,
        public readonly ?string $subindicadorCodigo = null,
        public readonly ?string $dataContato = null,
        public readonly ?string $comentario = null,
        public readonly ?string $responsavelContato = null,
        public readonly ?string $diretoriaNome = null,
        public readonly ?string $diretoriaId = null,
        public readonly ?string $regionalNome = null,
        public readonly ?string $gerenciaId = null,
        public readonly ?string $agenciaNome = null,
        public readonly ?string $agenciaId = null,
        public readonly ?string $gerenteGestaoNome = null,
        public readonly ?string $gerenteGestaoId = null,
        public readonly ?string $gerenteNome = null,
        public readonly ?string $gerenteId = null,
        public readonly ?string $creditoPreAprovado = null,
        public readonly ?string $origemLead = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'registro_id' => $this->registroId,
            'data' => $this->data,
            'competencia' => $this->competencia,
            'nome_empresa' => $this->nomeEmpresa,
            'cnae' => $this->cnae,
            'segmento' => $this->segmento,
            'segmento_id' => $this->segmentoId,
            'produto_propenso' => $this->produtoPropenso,
            'familia_nome' => $this->familiaNome,
            'subproduto' => $this->subproduto,
            'id_indicador' => $this->idIndicador,
            'subindicador_codigo' => $this->subindicadorCodigo,
            'data_contato' => $this->dataContato,
            'comentario' => $this->comentario,
            'responsavel_contato' => $this->responsavelContato,
            'diretoria_nome' => $this->diretoriaNome,
            'diretoria_id' => $this->diretoriaId,
            'regional_nome' => $this->regionalNome,
            'gerencia_id' => $this->gerenciaId,
            'agencia_nome' => $this->agenciaNome,
            'agencia_id' => $this->agenciaId,
            'gerente_gestao_nome' => $this->gerenteGestaoNome,
            'gerente_gestao_id' => $this->gerenteGestaoId,
            'gerente_nome' => $this->gerenteNome,
            'gerente_id' => $this->gerenteId,
            'credito_pre_aprovado' => $this->creditoPreAprovado,
            'origem_lead' => $this->origemLead,
        ];
    }
}
