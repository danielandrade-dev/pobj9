<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_realizados')]
class FRealizado
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(name: 'id_contrato', type: 'string', length: 10)]
    private string $idContrato;

    #[ORM\Column(name: 'data_realizado', type: 'date')]
    private \DateTimeInterface $dataRealizado;

    #[ORM\Column(type: 'string', length: 16)]
    private string $funcional;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, options: ['default' => '0.00'])]
    private string $realizado;

    #[ORM\Column(name: 'familia_id', type: 'integer', nullable: true)]
    private ?int $familiaId = null;

    #[ORM\Column(name: 'indicador_id', type: 'integer', nullable: true)]
    private ?int $indicadorId = null;

    #[ORM\Column(name: 'subindicador_id', type: 'integer', nullable: true)]
    private ?int $subindicadorId = null;

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

    public function getIdContrato(): string
    {
        return $this->idContrato;
    }

    public function setIdContrato(string $idContrato): self
    {
        $this->idContrato = $idContrato;
        return $this;
    }

    public function getDataRealizado(): \DateTimeInterface
    {
        return $this->dataRealizado;
    }

    public function setDataRealizado(\DateTimeInterface $dataRealizado): self
    {
        $this->dataRealizado = $dataRealizado;
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

    public function getRealizado(): string
    {
        return $this->realizado;
    }

    public function setRealizado(string $realizado): self
    {
        $this->realizado = $realizado;
        return $this;
    }

    public function getFamiliaId(): ?int
    {
        return $this->familiaId;
    }

    public function setFamiliaId(?int $familiaId): self
    {
        $this->familiaId = $familiaId;
        return $this;
    }

    public function getIndicadorId(): ?int
    {
        return $this->indicadorId;
    }

    public function setIndicadorId(?int $indicadorId): self
    {
        $this->indicadorId = $indicadorId;
        return $this;
    }

    public function getSubindicadorId(): ?int
    {
        return $this->subindicadorId;
    }

    public function setSubindicadorId(?int $subindicadorId): self
    {
        $this->subindicadorId = $subindicadorId;
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
