<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'd_unidade')]
class DUnidade
{
    #[ORM\Id]
    #[ORM\Column(name: 'agencia_id', type: 'smallint', options: ['unsigned' => true])]
    private int $agenciaId;

    #[ORM\Column(name: 'segmento_id', type: 'smallint', options: ['unsigned' => true])]
    private int $segmentoId;

    #[ORM\Column(type: 'string', length: 150)]
    private string $segmento;

    #[ORM\Column(name: 'segmento_label', type: 'string', length: 150)]
    private string $segmentoLabel;

    #[ORM\Column(name: 'diretoria_id', type: 'smallint', options: ['unsigned' => true])]
    private int $diretoriaId;

    #[ORM\Column(type: 'string', length: 150)]
    private string $diretoria;

    #[ORM\Column(name: 'diretoria_label', type: 'string', length: 150)]
    private string $diretoriaLabel;

    #[ORM\Column(name: 'regional_id', type: 'smallint', options: ['unsigned' => true])]
    private int $regionalId;

    #[ORM\Column(type: 'string', length: 150)]
    private string $regional;

    #[ORM\Column(name: 'regional_label', type: 'string', length: 150)]
    private string $regionalLabel;

    #[ORM\Column(type: 'string', length: 150)]
    private string $agencia;

    #[ORM\Column(name: 'agencia_label', type: 'string', length: 150)]
    private string $agenciaLabel;

    #[ORM\Column(name: 'gerente_id', type: 'string', length: 16, nullable: true)]
    private ?string $gerenteId = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $gerente = null;

    #[ORM\Column(name: 'gerente_gestao_id', type: 'string', length: 16, nullable: true)]
    private ?string $gerenteGestaoId = null;

    #[ORM\Column(name: 'gerente_gestao', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteGestao = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $porte = null;

    public function getAgenciaId(): int
    {
        return $this->agenciaId;
    }

    public function setAgenciaId(int $agenciaId): self
    {
        $this->agenciaId = $agenciaId;
        return $this;
    }

    public function getSegmentoId(): int
    {
        return $this->segmentoId;
    }

    public function setSegmentoId(int $segmentoId): self
    {
        $this->segmentoId = $segmentoId;
        return $this;
    }

    public function getSegmento(): string
    {
        return $this->segmento;
    }

    public function setSegmento(string $segmento): self
    {
        $this->segmento = $segmento;
        return $this;
    }

    public function getSegmentoLabel(): string
    {
        return $this->segmentoLabel;
    }

    public function setSegmentoLabel(string $segmentoLabel): self
    {
        $this->segmentoLabel = $segmentoLabel;
        return $this;
    }

    public function getDiretoriaId(): int
    {
        return $this->diretoriaId;
    }

    public function setDiretoriaId(int $diretoriaId): self
    {
        $this->diretoriaId = $diretoriaId;
        return $this;
    }

    public function getDiretoria(): string
    {
        return $this->diretoria;
    }

    public function setDiretoria(string $diretoria): self
    {
        $this->diretoria = $diretoria;
        return $this;
    }

    public function getDiretoriaLabel(): string
    {
        return $this->diretoriaLabel;
    }

    public function setDiretoriaLabel(string $diretoriaLabel): self
    {
        $this->diretoriaLabel = $diretoriaLabel;
        return $this;
    }

    public function getRegionalId(): int
    {
        return $this->regionalId;
    }

    public function setRegionalId(int $regionalId): self
    {
        $this->regionalId = $regionalId;
        return $this;
    }

    public function getRegional(): string
    {
        return $this->regional;
    }

    public function setRegional(string $regional): self
    {
        $this->regional = $regional;
        return $this;
    }

    public function getRegionalLabel(): string
    {
        return $this->regionalLabel;
    }

    public function setRegionalLabel(string $regionalLabel): self
    {
        $this->regionalLabel = $regionalLabel;
        return $this;
    }

    public function getAgencia(): string
    {
        return $this->agencia;
    }

    public function setAgencia(string $agencia): self
    {
        $this->agencia = $agencia;
        return $this;
    }

    public function getAgenciaLabel(): string
    {
        return $this->agenciaLabel;
    }

    public function setAgenciaLabel(string $agenciaLabel): self
    {
        $this->agenciaLabel = $agenciaLabel;
        return $this;
    }

    public function getGerenteId(): ?string
    {
        return $this->gerenteId;
    }

    public function setGerenteId(?string $gerenteId): self
    {
        $this->gerenteId = $gerenteId;
        return $this;
    }

    public function getGerente(): ?string
    {
        return $this->gerente;
    }

    public function setGerente(?string $gerente): self
    {
        $this->gerente = $gerente;
        return $this;
    }

    public function getGerenteGestaoId(): ?string
    {
        return $this->gerenteGestaoId;
    }

    public function setGerenteGestaoId(?string $gerenteGestaoId): self
    {
        $this->gerenteGestaoId = $gerenteGestaoId;
        return $this;
    }

    public function getGerenteGestao(): ?string
    {
        return $this->gerenteGestao;
    }

    public function setGerenteGestao(?string $gerenteGestao): self
    {
        $this->gerenteGestao = $gerenteGestao;
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
}
