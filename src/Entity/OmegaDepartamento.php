<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'omega_departamentos')]
class OmegaDepartamento
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 120)]
    private string $departamento;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 120)]
    private string $tipo;

    #[ORM\Column(name: 'departamento_id', type: 'string', length: 30, unique: true)]
    private string $departamentoId;

    #[ORM\Column(name: 'ordem_departamento', type: 'integer', nullable: true)]
    private ?int $ordemDepartamento = null;

    #[ORM\Column(name: 'ordem_tipo', type: 'integer', nullable: true)]
    private ?int $ordemTipo = null;

    public function getDepartamento(): string
    {
        return $this->departamento;
    }

    public function setDepartamento(string $departamento): self
    {
        $this->departamento = $departamento;
        return $this;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getDepartamentoId(): string
    {
        return $this->departamentoId;
    }

    public function setDepartamentoId(string $departamentoId): self
    {
        $this->departamentoId = $departamentoId;
        return $this;
    }

    public function getOrdemDepartamento(): ?int
    {
        return $this->ordemDepartamento;
    }

    public function setOrdemDepartamento(?int $ordemDepartamento): self
    {
        $this->ordemDepartamento = $ordemDepartamento;
        return $this;
    }

    public function getOrdemTipo(): ?int
    {
        return $this->ordemTipo;
    }

    public function setOrdemTipo(?int $ordemTipo): self
    {
        $this->ordemTipo = $ordemTipo;
        return $this;
    }
}

