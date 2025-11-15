<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class MetaDTO extends BaseFactDTO
{
    public function __construct(
        public readonly ?string $registroId = null,
        public readonly ?string $segmento = null,
        public readonly ?string $segmentoId = null,
        public readonly ?string $diretoriaId = null,
        public readonly ?string $diretoriaNome = null,
        public readonly ?string $gerenciaId = null,
        public readonly ?string $gerenciaNome = null,
        public readonly ?string $regionalNome = null,
        public readonly ?string $agenciaId = null,
        public readonly ?string $agenciaNome = null,
        public readonly ?string $gerenteGestaoId = null,
        public readonly ?string $gerenteGestaoNome = null,
        public readonly ?string $gerenteId = null,
        public readonly ?string $gerenteNome = null,
        public readonly ?string $familiaId = null,
        public readonly ?string $familiaNome = null,
        public readonly ?string $idIndicador = null,
        public readonly ?string $dsIndicador = null,
        public readonly ?string $subproduto = null,
        public readonly ?string $subindicadorCodigo = null,
        public readonly ?string $familiaCodigo = null,
        public readonly ?string $indicadorCodigo = null,
        public readonly ?string $carteira = null,
        public readonly ?string $canalVenda = null,
        public readonly ?string $tipoVenda = null,
        public readonly ?string $modalidadePagamento = null,
        public readonly ?string $data = null,
        public readonly ?string $competencia = null,
        public readonly ?float $metaMensal = null,
        public readonly ?float $metaAcumulada = null,
        public readonly ?float $variavelMeta = null,
        public readonly ?float $peso = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'registro_id' => $this->registroId,
            'segmento' => $this->segmento,
            'segmento_id' => $this->segmentoId,
            'diretoria_id' => $this->diretoriaId,
            'diretoria_nome' => $this->diretoriaNome,
            'gerencia_id' => $this->gerenciaId,
            'gerencia_nome' => $this->gerenciaNome,
            'regional_nome' => $this->regionalNome,
            'agencia_id' => $this->agenciaId,
            'agencia_nome' => $this->agenciaNome,
            'gerente_gestao_id' => $this->gerenteGestaoId,
            'gerente_gestao_nome' => $this->gerenteGestaoNome,
            'gerente_id' => $this->gerenteId,
            'gerente_nome' => $this->gerenteNome,
            'familia_id' => $this->familiaId,
            'familia_nome' => $this->familiaNome,
            'id_indicador' => $this->idIndicador,
            'ds_indicador' => $this->dsIndicador,
            'subproduto' => $this->subproduto,
            'subindicador_codigo' => $this->subindicadorCodigo,
            'familia_codigo' => $this->familiaCodigo,
            'indicador_codigo' => $this->indicadorCodigo,
            'carteira' => $this->carteira,
            'canal_venda' => $this->canalVenda,
            'tipo_venda' => $this->tipoVenda,
            'modalidade_pagamento' => $this->modalidadePagamento,
            'data' => $this->data,
            'competencia' => $this->competencia,
            'meta_mensal' => $this->metaMensal,
            'meta_acumulada' => $this->metaAcumulada,
            'variavel_meta' => $this->variavelMeta,
            'peso' => $this->peso,
        ];
    }
}
