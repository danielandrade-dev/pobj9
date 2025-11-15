<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'd_produtos')]
class DProduto
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'id_familia', type: 'integer')]
    private int $idFamilia;

    #[ORM\Column(type: 'string', length: 120)]
    private string $familia;

    #[ORM\Column(name: 'id_indicador', type: 'integer')]
    private int $idIndicador;

    #[ORM\Column(type: 'string', length: 120)]
    private string $indicador;

    #[ORM\Column(name: 'id_subindicador', type: 'integer', nullable: true)]
    private ?int $idSubindicador = null;

    #[ORM\Column(type: 'string', length: 120, nullable: true)]
    private ?string $subindicador = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: ['default' => '0.00'])]
    private string $peso;

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdFamilia(): int
    {
        return $this->idFamilia;
    }

    public function setIdFamilia(int $idFamilia): self
    {
        $this->idFamilia = $idFamilia;
        return $this;
    }

    public function getFamilia(): string
    {
        return $this->familia;
    }

    public function setFamilia(string $familia): self
    {
        $this->familia = $familia;
        return $this;
    }

    public function getIdIndicador(): int
    {
        return $this->idIndicador;
    }

    public function setIdIndicador(int $idIndicador): self
    {
        $this->idIndicador = $idIndicador;
        return $this;
    }

    public function getIndicador(): string
    {
        return $this->indicador;
    }

    public function setIndicador(string $indicador): self
    {
        $this->indicador = $indicador;
        return $this;
    }

    public function getIdSubindicador(): ?int
    {
        return $this->idSubindicador;
    }

    public function setIdSubindicador(?int $idSubindicador): self
    {
        $this->idSubindicador = $idSubindicador;
        return $this;
    }

    public function getSubindicador(): ?string
    {
        return $this->subindicador;
    }

    public function setSubindicador(?string $subindicador): self
    {
        $this->subindicador = $subindicador;
        return $this;
    }

    public function getPeso(): string
    {
        return $this->peso;
    }

    public function setPeso(string $peso): self
    {
        $this->peso = $peso;
        return $this;
    }
}
