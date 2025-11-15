<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class ProdutoDTO extends BaseFactDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $idFamilia = null,
        public readonly ?string $familia = null,
        public readonly ?string $idIndicador = null,
        public readonly ?string $indicador = null,
        public readonly ?string $idSubindicador = null,
        public readonly ?string $subindicador = null,
        public readonly ?float $peso = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'idFamilia' => $this->idFamilia,
            'Familia' => $this->familia,
            'IdIndicador' => $this->idIndicador,
            'Indicador' => $this->indicador,
            'idSubindicador' => $this->idSubindicador,
            'Subindicador' => $this->subindicador,
            'Peso' => $this->peso,
        ];
    }
}

