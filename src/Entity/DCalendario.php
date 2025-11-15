<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'd_calendario')]
class DCalendario
{
    #[ORM\Id]
    #[ORM\Column(type: 'date_immutable')]
    private \DateTimeImmutable $data;

    #[ORM\Column(type: 'integer')]
    private int $ano;

    #[ORM\Column(type: 'smallint')]
    private int $mes;

    #[ORM\Column(name: 'mes_nome', type: 'string', length: 20)]
    private string $mesNome;

    #[ORM\Column(type: 'smallint')]
    private int $dia;

    #[ORM\Column(name: 'dia_da_semana', type: 'string', length: 20)]
    private string $diaDaSemana;

    #[ORM\Column(type: 'smallint')]
    private int $semana;

    #[ORM\Column(type: 'smallint')]
    private int $trimestre;

    #[ORM\Column(type: 'smallint')]
    private int $semestre;

    #[ORM\Column(name: 'eh_dia_util', type: 'boolean', options: ['default' => false])]
    private bool $ehDiaUtil = false;

    public function getData(): \DateTimeImmutable
    {
        return $this->data;
    }

    public function setData(\DateTimeImmutable $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function setAno(int $ano): self
    {
        $this->ano = $ano;
        return $this;
    }

    public function getMes(): int
    {
        return $this->mes;
    }

    public function setMes(int $mes): self
    {
        $this->mes = $mes;
        return $this;
    }

    public function getMesNome(): string
    {
        return $this->mesNome;
    }

    public function setMesNome(string $mesNome): self
    {
        $this->mesNome = $mesNome;
        return $this;
    }

    public function getDia(): int
    {
        return $this->dia;
    }

    public function setDia(int $dia): self
    {
        $this->dia = $dia;
        return $this;
    }

    public function getDiaDaSemana(): string
    {
        return $this->diaDaSemana;
    }

    public function setDiaDaSemana(string $diaDaSemana): self
    {
        $this->diaDaSemana = $diaDaSemana;
        return $this;
    }

    public function getSemana(): int
    {
        return $this->semana;
    }

    public function setSemana(int $semana): self
    {
        $this->semana = $semana;
        return $this;
    }

    public function getTrimestre(): int
    {
        return $this->trimestre;
    }

    public function setTrimestre(int $trimestre): self
    {
        $this->trimestre = $trimestre;
        return $this;
    }

    public function getSemestre(): int
    {
        return $this->semestre;
    }

    public function setSemestre(int $semestre): self
    {
        $this->semestre = $semestre;
        return $this;
    }

    public function isEhDiaUtil(): bool
    {
        return $this->ehDiaUtil;
    }

    public function setEhDiaUtil(bool $ehDiaUtil): self
    {
        $this->ehDiaUtil = $ehDiaUtil;
        return $this;
    }

    public function __toString(): string
    {
        return $this->data->format('Y-m-d');
    }
}

