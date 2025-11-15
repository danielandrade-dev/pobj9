<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class OmegaStatusDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $label,
        public readonly string $tone = 'neutral',
        public readonly ?string $descricao = null,
        public readonly ?int $ordem = null,
        public readonly ?string $departamentoId = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'tone' => $this->tone,
            'descricao' => $this->descricao,
            'ordem' => $this->ordem,
            'departamento_id' => $this->departamentoId,
        ];
    }
}

