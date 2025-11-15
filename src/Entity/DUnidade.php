<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'd_unidade')]
class DUnidade
{
    #[ORM\Id]
    #[ORM\Column(name: 'segmento_id', type: 'string', length: 50)]
    private string $segmentoId;

    #[ORM\Id]
    #[ORM\Column(name: 'diretoria_id', type: 'string', length: 50)]
    private string $diretoriaId;

    #[ORM\Id]
    #[ORM\Column(name: 'gerencia_regional_id', type: 'string', length: 50)]
    private string $gerenciaRegionalId;

    #[ORM\Id]
    #[ORM\Column(name: 'agencia_id', type: 'string', length: 50, unique: true)]
    private string $agenciaId;

    #[ORM\Column(type: 'string', length: 100)]
    private string $segmento;

    #[ORM\Column(name: 'diretoria_regional', type: 'string', length: 150)]
    private string $diretoriaRegional;

    #[ORM\Column(name: 'gerencia_regional', type: 'string', length: 150)]
    private string $gerenciaRegional;

    #[ORM\Column(type: 'string', length: 150)]
    private string $agencia;

    #[ORM\Column(name: 'gerente_gestao', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteGestao = null;

    #[ORM\Column(name: 'gerente_gestao_id', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteGestaoId = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $gerente = null;

    #[ORM\Column(name: 'gerente_id', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteId = null;

    public function getSegmentoId(): string
    {
        return $this->segmentoId;
    }

    public function setSegmentoId(string $segmentoId): self
    {
        $this->segmentoId = $segmentoId;
        return $this;
    }

    public function getDiretoriaId(): string
    {
        return $this->diretoriaId;
    }

    public function setDiretoriaId(string $diretoriaId): self
    {
        $this->diretoriaId = $diretoriaId;
        return $this;
    }

    public function getGerenciaRegionalId(): string
    {
        return $this->gerenciaRegionalId;
    }

    public function setGerenciaRegionalId(string $gerenciaRegionalId): self
    {
        $this->gerenciaRegionalId = $gerenciaRegionalId;
        return $this;
    }

    public function getAgenciaId(): string
    {
        return $this->agenciaId;
    }

    public function setAgenciaId(string $agenciaId): self
    {
        $this->agenciaId = $agenciaId;
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

    public function getDiretoriaRegional(): string
    {
        return $this->diretoriaRegional;
    }

    public function setDiretoriaRegional(string $diretoriaRegional): self
    {
        $this->diretoriaRegional = $diretoriaRegional;
        return $this;
    }

    public function getGerenciaRegional(): string
    {
        return $this->gerenciaRegional;
    }

    public function setGerenciaRegional(string $gerenciaRegional): self
    {
        $this->gerenciaRegional = $gerenciaRegional;
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

    public function getGerenteGestao(): ?string
    {
        return $this->gerenteGestao;
    }

    public function setGerenteGestao(?string $gerenteGestao): self
    {
        $this->gerenteGestao = $gerenteGestao;
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

    public function getGerente(): ?string
    {
        return $this->gerente;
    }

    public function setGerente(?string $gerente): self
    {
        $this->gerente = $gerente;
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
}

