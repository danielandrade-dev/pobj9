<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class VariavelDTO extends BaseFactDTO
{
    public function __construct(
        public readonly ?string $registroId = null,
        public readonly ?string $idIndicador = null,
        public readonly ?string $dsIndicador = null,
        public readonly ?string $familiaId = null,
        public readonly ?string $familiaNome = null,
        public readonly ?string $familiaCodigo = null,
        public readonly ?string $indicadorCodigo = null,
        public readonly ?string $subindicadorCodigo = null,
        public readonly ?string $data = null,
        public readonly ?string $competencia = null,
        public readonly ?float $variavelReal = null,
        public readonly ?float $variavelMeta = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'registro_id' => $this->registroId,
            'id_indicador' => $this->idIndicador,
            'ds_indicador' => $this->dsIndicador,
            'familia_id' => $this->familiaId,
            'familia_nome' => $this->familiaNome,
            'familia_codigo' => $this->familiaCodigo,
            'indicador_codigo' => $this->indicadorCodigo,
            'subindicador_codigo' => $this->subindicadorCodigo,
            'data' => $this->data,
            'competencia' => $this->competencia,
            'variavel_real' => $this->variavelReal,
            'variavel_meta' => $this->variavelMeta,
        ];
    }
}
