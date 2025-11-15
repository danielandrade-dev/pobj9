<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class OmegaStructureDTO
{
    public function __construct(
        public readonly string $departamento,
        public readonly string $tipo,
        public readonly string $departamentoId,
        public readonly ?int $ordemDepartamento = null,
        public readonly ?int $ordemTipo = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'departamento' => $this->departamento,
            'tipo' => $this->tipo,
            'departamento_id' => $this->departamentoId,
            'ordem_departamento' => $this->ordemDepartamento,
            'ordem_tipo' => $this->ordemTipo,
        ];
    }
}

