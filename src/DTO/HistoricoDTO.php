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
            'nivel' => $this->nivel,
            'ano' => $this->ano,
            'data' => $this->data,
            'competencia' => $this->competencia,
            'segmento' => $this->segmento,
            'segmento_id' => $this->segmentoId,
            'diretoria_id' => $this->diretoriaId,
            'diretoria_nome' => $this->diretoriaNome,
            'gerencia_id' => $this->gerenciaId,
            'gerencia_nome' => $this->gerenciaNome,
            'agencia_id' => $this->agenciaId,
            'agencia_nome' => $this->agenciaNome,
            'gerente_gestao_id' => $this->gerenteGestaoId,
            'gerente_gestao_nome' => $this->gerenteGestaoNome,
            'gerente_id' => $this->gerenteId,
            'gerente_nome' => $this->gerenteNome,
            'participantes' => $this->participantes,
            'rank' => $this->rank,
            'pontos' => $this->pontos,
            'realizado_mensal' => $this->realizadoMensal,
            'meta_mensal' => $this->metaMensal,
        ];
    }
}
