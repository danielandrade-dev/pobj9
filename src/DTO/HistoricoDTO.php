<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class HistoricoDTO extends BaseFactDTO
{
    public function __construct(
        public readonly ?string $nivel = null,
        public readonly ?int $ano = null,
        public readonly ?string $data = null,
        public readonly ?string $competencia = null,
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
        public readonly ?int $participantes = null,
        public readonly ?int $rank = null,
        public readonly ?float $pontos = null,
        public readonly ?float $realizadoMensal = null,
        public readonly ?float $metaMensal = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'Nivel' => $this->nivel,
            'Ano' => $this->ano,
            'Data' => $this->data,
            'Competencia' => $this->competencia,
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
            'Participantes' => $this->participantes,
            'Rank' => $this->rank,
            'Pontos' => $this->pontos,
            'Realizado Mensal' => $this->realizadoMensal,
            'Meta Mensal' => $this->metaMensal,
        ];
    }
}

