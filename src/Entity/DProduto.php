<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'd_produtos')]
class DProduto
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 50)]
    private string $idIndicador;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 50, options: ['default' => '0'])]
    private string $idSubindicador;

    #[ORM\Column(type: 'tinyint')]
    private int $idFamilia;

    #[ORM\Column(type: 'string', length: 100)]
    private string $familia;

    #[ORM\Column(type: 'string', length: 100)]
    private string $familiaSlug;

    #[ORM\Column(type: 'string', length: 150)]
    private string $indicador;

    #[ORM\Column(type: 'string', length: 150, unique: true)]
    private string $indicadorSlug;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $subindicador = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $subindicadorSlug = null;

    public function getIdIndicador(): string
    {
        return $this->idIndicador;
    }

    public function setIdIndicador(string $idIndicador): self
    {
        $this->idIndicador = $idIndicador;
        return $this;
    }

    public function getIdSubindicador(): string
    {
        return $this->idSubindicador;
    }

    public function setIdSubindicador(string $idSubindicador): self
    {
        $this->idSubindicador = $idSubindicador;
        return $this;
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

    public function getFamiliaSlug(): string
    {
        return $this->familiaSlug;
    }

    public function setFamiliaSlug(string $familiaSlug): self
    {
        $this->familiaSlug = $familiaSlug;
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

    public function getIndicadorSlug(): string
    {
        return $this->indicadorSlug;
    }

    public function setIndicadorSlug(string $indicadorSlug): self
    {
        $this->indicadorSlug = $indicadorSlug;
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

    public function getSubindicadorSlug(): ?string
    {
        return $this->subindicadorSlug;
    }

    public function setSubindicadorSlug(?string $subindicadorSlug): self
    {
        $this->subindicadorSlug = $subindicadorSlug;
        return $this;
    }
}

