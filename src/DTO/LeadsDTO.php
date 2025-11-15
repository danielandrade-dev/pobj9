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
            'Registro ID' => $this->registroId,
            'Data' => $this->data,
            'Competencia' => $this->competencia,
            'Nome Empresa' => $this->nomeEmpresa,
            'CNAE' => $this->cnae,
            'Segmento' => $this->segmento,
            'Segmento ID' => $this->segmentoId,
            'Produto Propenso' => $this->produtoPropenso,
            'Familia Nome' => $this->familiaNome,
            'Subproduto' => $this->subproduto,
            'id_indicador' => $this->idIndicador,
            'Subindicador Codigo' => $this->subindicadorCodigo,
            'Data Contato' => $this->dataContato,
            'Comentario' => $this->comentario,
            'Responsavel Contato' => $this->responsavelContato,
            'Diretoria Nome' => $this->diretoriaNome,
            'Diretoria ID' => $this->diretoriaId,
            'Regional Nome' => $this->regionalNome,
            'Gerencia ID' => $this->gerenciaId,
            'Agencia Nome' => $this->agenciaNome,
            'Agencia ID' => $this->agenciaId,
            'Gerente Gestao Nome' => $this->gerenteGestaoNome,
            'Gerente Gestao ID' => $this->gerenteGestaoId,
            'Gerente Nome' => $this->gerenteNome,
            'Gerente ID' => $this->gerenteId,
            'Credito Pre Aprovado' => $this->creditoPreAprovado,
            'Origem Lead' => $this->origemLead,
        ];
    }
}

