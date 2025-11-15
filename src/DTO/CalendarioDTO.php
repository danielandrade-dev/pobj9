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
            'Data' => $this->data,
            'Competencia' => $this->competencia,
            'Ano' => $this->ano,
            'Mes' => $this->mes,
            'Mes Nome' => $this->mesNome,
            'Dia' => $this->dia,
            'Dia da Semana' => $this->diaDaSemana,
            'Semana' => $this->semana,
            'Trimestre' => $this->trimestre,
            'Semestre' => $this->semestre,
            'Eh Dia Util' => $this->ehDiaUtil,
        ];
    }
}

