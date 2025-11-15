<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'd_estrutura')]
class DEstrutura
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 20)]
    private string $funcional;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nome;

    #[ORM\Column(type: 'string', length: 120)]
    private string $cargo;

    #[ORM\Column(name: 'id_cargo', type: 'integer', nullable: true)]
    private ?int $idCargo = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $agencia = null;

    #[ORM\Column(name: 'id_agencia', type: 'integer', nullable: true)]
    private ?int $idAgencia = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $porte = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $regional = null;

    #[ORM\Column(name: 'id_regional', type: 'integer', nullable: true)]
    private ?int $idRegional = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $diretoria = null;

    #[ORM\Column(name: 'id_diretoria', type: 'integer', nullable: true)]
    private ?int $idDiretoria = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $segmento = null;

    #[ORM\Column(name: 'id_segmento', type: 'integer', nullable: true)]
    private ?int $idSegmento = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $rede = null;

    #[ORM\Column(name: 'created_at', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $createdAt;

    public function getFuncional(): string
    {
        return $this->funcional;
    }

    public function setFuncional(string $funcional): self
    {
        $this->funcional = $funcional;
        return $this;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getCargo(): string
    {
        return $this->cargo;
    }

    public function setCargo(string $cargo): self
    {
        $this->cargo = $cargo;
        return $this;
    }

    public function getIdCargo(): ?int
    {
        return $this->idCargo;
    }

    public function setIdCargo(?int $idCargo): self
    {
        $this->idCargo = $idCargo;
        return $this;
    }

    public function getAgencia(): ?string
    {
        return $this->agencia;
    }

    public function setAgencia(?string $agencia): self
    {
        $this->agencia = $agencia;
        return $this;
    }

    public function getIdAgencia(): ?int
    {
        return $this->idAgencia;
    }

    public function setIdAgencia(?int $idAgencia): self
    {
        $this->idAgencia = $idAgencia;
        return $this;
    }

    public function getPorte(): ?string
    {
        return $this->porte;
    }

    public function setPorte(?string $porte): self
    {
        $this->porte = $porte;
        return $this;
    }

    public function getRegional(): ?string
    {
        return $this->regional;
    }

    public function setRegional(?string $regional): self
    {
        $this->regional = $regional;
        return $this;
    }

    public function getIdRegional(): ?int
    {
        return $this->idRegional;
    }

    public function setIdRegional(?int $idRegional): self
    {
        $this->idRegional = $idRegional;
        return $this;
    }

    public function getDiretoria(): ?string
    {
        return $this->diretoria;
    }

    public function setDiretoria(?string $diretoria): self
    {
        $this->diretoria = $diretoria;
        return $this;
    }

    public function getIdDiretoria(): ?int
    {
        return $this->idDiretoria;
    }

    public function setIdDiretoria(?int $idDiretoria): self
    {
        $this->idDiretoria = $idDiretoria;
        return $this;
    }

    public function getSegmento(): ?string
    {
        return $this->segmento;
    }

    public function setSegmento(?string $segmento): self
    {
        $this->segmento = $segmento;
        return $this;
    }

    public function getIdSegmento(): ?int
    {
        return $this->idSegmento;
    }

    public function setIdSegmento(?int $idSegmento): self
    {
        $this->idSegmento = $idSegmento;
        return $this;
    }

    public function getRede(): ?string
    {
        return $this->rede;
    }

    public function setRede(?string $rede): self
    {
        $this->rede = $rede;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}

