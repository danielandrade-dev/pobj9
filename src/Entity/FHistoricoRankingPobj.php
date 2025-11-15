<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_historico_ranking_pobj')]
class FHistoricoRankingPobj
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 30)]
    private string $nivel;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $ano;

    #[ORM\Id]
    #[ORM\Column(type: 'date_immutable')]
    private \DateTimeImmutable $database;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $segmento = null;

    #[ORM\Column(name: 'segmento_id', type: 'string', length: 50, nullable: true)]
    private ?string $segmentoId = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $diretoria = null;

    #[ORM\Column(name: 'diretoria_nome', type: 'string', length: 150, nullable: true)]
    private ?string $diretoriaNome = null;

    #[ORM\Column(name: 'gerencia_regional', type: 'string', length: 50, nullable: true)]
    private ?string $gerenciaRegional = null;

    #[ORM\Column(name: 'gerencia_regional_nome', type: 'string', length: 150, nullable: true)]
    private ?string $gerenciaRegionalNome = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $agencia = null;

    #[ORM\Column(name: 'agencia_nome', type: 'string', length: 150, nullable: true)]
    private ?string $agenciaNome = null;

    #[ORM\Column(name: 'gerente_gestao', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteGestao = null;

    #[ORM\Column(name: 'gerente_gestao_nome', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteGestaoNome = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $gerente = null;

    #[ORM\Column(name: 'gerente_nome', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteNome = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $participantes = null;

    #[ORM\Column(name: 'rank', type: 'integer', nullable: true)]
    private ?int $rank = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $pontos = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $realizado = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $meta = null;

    public function getNivel(): string
    {
        return $this->nivel;
    }

    public function setNivel(string $nivel): self
    {
        $this->nivel = $nivel;
        return $this;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function getSegmento(): ?string
    {
        return $this->segmento;
    }

    public function getSegmentoId(): ?string
    {
        return $this->segmentoId;
    }

    public function getDiretoria(): ?string
    {
        return $this->diretoria;
    }

    public function getDiretoriaNome(): ?string
    {
        return $this->diretoriaNome;
    }

    public function getGerenciaRegional(): ?string
    {
        return $this->gerenciaRegional;
    }

    public function getGerenciaRegionalNome(): ?string
    {
        return $this->gerenciaRegionalNome;
    }

    public function getAgencia(): ?string
    {
        return $this->agencia;
    }

    public function getAgenciaNome(): ?string
    {
        return $this->agenciaNome;
    }

    public function getGerenteGestao(): ?string
    {
        return $this->gerenteGestao;
    }

    public function getGerenteGestaoNome(): ?string
    {
        return $this->gerenteGestaoNome;
    }

    public function getGerente(): ?string
    {
        return $this->gerente;
    }

    public function getGerenteNome(): ?string
    {
        return $this->gerenteNome;
    }

    public function getParticipantes(): ?int
    {
        return $this->participantes;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function getPontos(): ?string
    {
        return $this->pontos;
    }

    public function getRealizado(): ?string
    {
        return $this->realizado;
    }

    public function getMeta(): ?string
    {
        return $this->meta;
    }

    public function getDatabase(): \DateTimeImmutable
    {
        return $this->database;
    }

    public function setDatabase(\DateTimeImmutable $database): self
    {
        $this->database = $database;
        return $this;
    }

    public function __toString(): string
    {
        return $this->nivel . '_' . $this->ano . '_' . $this->database->format('Y-m-d');
    }
}

