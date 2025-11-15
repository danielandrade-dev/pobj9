<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class DetalhesDTO extends BaseFactDTO
{
    public function __construct(
        public readonly ?string $registroId = null,
        public readonly ?string $segmento = null,
        public readonly ?string $segmentoId = null,
        public readonly ?string $diretoriaId = null,
        public readonly ?string $diretoriaNome = null,
        public readonly ?string $gerenciaId = null,
        public readonly ?string $gerenciaNome = null,
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
        public readonly ?float $realizadoMensal = null,
        public readonly ?float $quantidade = null,
        public readonly ?float $peso = null,
        public readonly ?float $pontos = null,
        public readonly ?string $statusId = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'Registro ID' => $this->registroId,
            'Segmento' => $this->segmento,
            'Segmento ID' => $this->segmentoId,
            'Diretoria ID' => $this->diretoriaId,
            'Diretoria Nome' => $this->diretoriaNome,
            'Gerencia ID' => $this->gerenciaId,
            'Gerencia Nome' => $this->gerenciaNome,
            'Agencia ID' => $this->agenciaId,
            'Agencia Nome' => $this->agenciaNome,
            'Gerente Gestao ID' => $this->gerenteGestaoId,
            'Gerente Gestao Nome' => $this->gerenteGestaoNome,
            'Gerente ID' => $this->gerenteId,
            'Gerente Nome' => $this->gerenteNome,
            'Familia ID' => $this->familiaId,
            'Familia Nome' => $this->familiaNome,
            'id_indicador' => $this->idIndicador,
            'ds_indicador' => $this->dsIndicador,
            'Subproduto' => $this->subproduto,
            'Subindicador Codigo' => $this->subindicadorCodigo,
            'Familia Codigo' => $this->familiaCodigo,
            'Indicador Codigo' => $this->indicadorCodigo,
            'Carteira' => $this->carteira,
            'Canal Venda' => $this->canalVenda,
            'Tipo Venda' => $this->tipoVenda,
            'Modalidade Pagamento' => $this->modalidadePagamento,
            'Data' => $this->data,
            'Competencia' => $this->competencia,
            'Meta Mensal' => $this->metaMensal,
            'Realizado Mensal' => $this->realizadoMensal,
            'Quantidade' => $this->quantidade,
            'Peso' => $this->peso,
            'Pontos' => $this->pontos,
            'Status ID' => $this->statusId,
        ];
    }
}

