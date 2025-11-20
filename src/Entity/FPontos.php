<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(
    name: 'f_pontos',
    indexes: [
        new ORM\Index(name: 'idx_fp_data_realizado', columns: ['data_realizado']),
        new ORM\Index(name: 'idx_fp_id_familia', columns: ['id_familia']),
        new ORM\Index(name: 'idx_fp_familia_indicador', columns: ['id_familia', 'id_indicador']),
    ]
)]
class FPontos
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'string', length: 20)]
    private string $funcional;

    #[ORM\Column(name: 'id_indicador', type: 'integer')]
    private int $idIndicador;

    #[ORM\Column(name: 'id_familia', type: 'integer', nullable: true)]
    private ?int $idFamilia = null;

    #[ORM\Column(type: 'string', length: 150)]
    private string $indicador;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, options: ['default' => '0.00'])]
    private string $meta;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, options: ['default' => '0.00'])]
    private string $realizado;

    #[ORM\Column(name: 'data_realizado', type: 'date', nullable: true)]
    private ?\DateTimeInterface $dataRealizado = null;

    #[ORM\Column(name: 'dt_atualizacao', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $dtAtualizacao;

    public function getId(): int
    {
        return $this->id;
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

    public function getIdIndicador(): int
    {
        return $this->idIndicador;
    }

    public function setIdIndicador(int $idIndicador): self
    {
        $this->idIndicador = $idIndicador;
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

    public function getIndicador(): string
    {
        return $this->indicador;
    }

    public function setIndicador(string $indicador): self
    {
        $this->indicador = $indicador;
        return $this;
    }

    public function getMeta(): string
    {
        return $this->meta;
    }

    public function setMeta(string $meta): self
    {
        $this->meta = $meta;
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

    public function getDataRealizado(): ?\DateTimeInterface
    {
        return $this->dataRealizado;
    }

    public function setDataRealizado(?\DateTimeInterface $dataRealizado): self
    {
        $this->dataRealizado = $dataRealizado;
        return $this;
    }

    public function getDtAtualizacao(): \DateTimeInterface
    {
        return $this->dtAtualizacao;
    }

    public function setDtAtualizacao(\DateTimeInterface $dtAtualizacao): self
    {
        $this->dtAtualizacao = $dtAtualizacao;
        return $this;
    }
}

