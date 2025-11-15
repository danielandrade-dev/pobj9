<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class CalendarioDTO extends BaseFactDTO
{
    public function __construct(
        public readonly ?string $data = null,
        public readonly ?string $competencia = null,
        public readonly ?int $ano = null,
        public readonly ?int $mes = null,
        public readonly ?string $mesNome = null,
        public readonly ?int $dia = null,
        public readonly ?string $diaDaSemana = null,
        public readonly ?int $semana = null,
        public readonly ?int $trimestre = null,
        public readonly ?int $semestre = null,
        public readonly ?string $ehDiaUtil = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'competencia' => $this->competencia,
            'ano' => $this->ano,
            'mes' => $this->mes,
            'mes_nome' => $this->mesNome,
            'dia' => $this->dia,
            'dia_da_semana' => $this->diaDaSemana,
            'semana' => $this->semana,
            'trimestre' => $this->trimestre,
            'semestre' => $this->semestre,
            'eh_dia_util' => $this->ehDiaUtil,
        ];
    }
}
