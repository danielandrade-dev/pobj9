<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_meta')]
class FMeta
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(name: 'data_meta', type: 'date')]
    private \DateTimeInterface $dataMeta;

    #[ORM\Column(type: 'string', length: 16)]
    private string $funcional;

    #[ORM\Column(name: 'meta_mensal', type: 'decimal', precision: 18, scale: 2, options: ['default' => '0.00'])]
    private string $metaMensal;

    #[ORM\Column(name: 'created_at', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(name: 'id_familia', type: 'integer', nullable: true)]
    private ?int $idFamilia = null;

    #[ORM\Column(name: 'id_indicador', type: 'integer', nullable: true)]
    private ?int $idIndicador = null;

    #[ORM\Column(name: 'id_subindicador', type: 'integer', nullable: true)]
    private ?int $idSubindicador = null;

    #[ORM\Column(name: 'segmento_id', type: 'integer', nullable: true)]
    private ?int $segmentoId = null;

    #[ORM\Column(name: 'diretoria_id', type: 'integer', nullable: true)]
    private ?int $diretoriaId = null;

    #[ORM\Column(name: 'gerencia_regional_id', type: 'integer', nullable: true)]
    private ?int $gerenciaRegionalId = null;

    #[ORM\Column(name: 'agencia_id', type: 'integer', nullable: true)]
    private ?int $agenciaId = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDataMeta(): \DateTimeInterface
    {
        return $this->dataMeta;
    }

    public function setDataMeta(\DateTimeInterface $dataMeta): self
    {
        $this->dataMeta = $dataMeta;
        return $this;
    }

    public function getFuncional(): string
    {
        return $this->funcional;
    }

    public function setFuncional(string $funcional): self
    {
        $this->funcional = $funcional;
        return $this;
    }

    public function getMetaMensal(): string
    {
        return $this->metaMensal;
    }

    public function setMetaMensal(string $metaMensal): self
    {
        $this->metaMensal = $metaMensal;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getIdFamilia(): ?int
    {
        return $this->idFamilia;
    }

    public function setIdFamilia(?int $idFamilia): self
    {
        $this->idFamilia = $idFamilia;
        return $this;
    }

    public function getIdIndicador(): ?int
    {
        return $this->idIndicador;
    }

    public function setIdIndicador(?int $idIndicador): self
    {
        $this->idIndicador = $idIndicador;
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

    public function getSegmentoId(): ?int
    {
        return $this->segmentoId;
    }

    public function setSegmentoId(?int $segmentoId): self
    {
        $this->segmentoId = $segmentoId;
        return $this;
    }

    public function getDiretoriaId(): ?int
    {
        return $this->diretoriaId;
    }

    public function setDiretoriaId(?int $diretoriaId): self
    {
        $this->diretoriaId = $diretoriaId;
        return $this;
    }

    public function getGerenciaRegionalId(): ?int
    {
        return $this->gerenciaRegionalId;
    }

    public function setGerenciaRegionalId(?int $gerenciaRegionalId): self
    {
        $this->gerenciaRegionalId = $gerenciaRegionalId;
        return $this;
    }

    public function getAgenciaId(): ?int
    {
        return $this->agenciaId;
    }

    public function setAgenciaId(?int $agenciaId): self
    {
        $this->agenciaId = $agenciaId;
        return $this;
    }
}
