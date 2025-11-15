<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class OmegaMesuDTO
{
    public function __construct(
        public readonly ?string $segmento = null,
        public readonly ?string $segmentoId = null,
        public readonly ?string $diretoria = null,
        public readonly ?string $diretoriaId = null,
        public readonly ?string $gerenciaRegional = null,
        public readonly ?string $gerenciaRegionalId = null,
        public readonly ?string $agencia = null,
        public readonly ?string $agenciaId = null,
        public readonly ?string $gerenteGestao = null,
        public readonly ?string $gerenteGestaoId = null,
        public readonly ?string $gerente = null,
        public readonly ?string $gerenteId = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'segmento' => $this->segmento,
            'segmento_id' => $this->segmentoId,
            'diretoria' => $this->diretoria,
            'diretoria_id' => $this->diretoriaId,
            'gerencia_regional' => $this->gerenciaRegional,
            'gerencia_regional_id' => $this->gerenciaRegionalId,
            'agencia' => $this->agencia,
            'agencia_id' => $this->agenciaId,
            'gerente_gestao' => $this->gerenteGestao,
            'gerente_gestao_id' => $this->gerenteGestaoId,
            'gerente' => $this->gerente,
            'gerente_id' => $this->gerenteId,
        ];
    }
}

