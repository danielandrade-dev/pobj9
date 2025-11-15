<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_campanhas')]
class FCampanhas
{
    #[ORM\Id]
    #[ORM\Column(name: 'campanha_id', type: 'string', length: 60)]
    private string $campanhaId;

    #[ORM\Column(name: 'sprint_id', type: 'string', length: 60)]
    private string $sprintId;

    #[ORM\Column(name: 'diretoria_id', type: 'string', length: 50)]
    private string $diretoriaId;

    #[ORM\Column(name: 'diretoria_nome', type: 'string', length: 150)]
    private string $diretoriaNome;

    #[ORM\Column(name: 'gerencia_regional_id', type: 'string', length: 50)]
    private string $gerenciaRegionalId;

    #[ORM\Column(name: 'regional_nome', type: 'string', length: 150)]
    private string $regionalNome;

    #[ORM\Column(name: 'agencia_id', type: 'string', length: 50)]
    private string $agenciaId;

    #[ORM\Column(name: 'agencia_nome', type: 'string', length: 150)]
    private string $agenciaNome;

    #[ORM\Column(name: 'gerente_gestao_id', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteGestaoId = null;

    #[ORM\Column(name: 'gerente_gestao_nome', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteGestaoNome = null;

    #[ORM\Column(name: 'gerente_id', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteId = null;

    #[ORM\Column(name: 'gerente_nome', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteNome = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $segmento;

    #[ORM\Column(name: 'segmento_id', type: 'string', length: 50)]
    private string $segmentoId;

    #[ORM\Column(name: 'familia_id', type: 'string', length: 20)]
    private string $familiaId;

    #[ORM\Column(name: 'id_indicador', type: 'string', length: 80)]
    private string $idIndicador;

    #[ORM\Column(name: 'ds_indicador', type: 'string', length: 150)]
    private string $dsIndicador;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $subproduto = null;

    #[ORM\Column(name: 'id_subindicador', type: 'string', length: 80, options: ['default' => '0'])]
    private string $idSubindicador = '0';

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $carteira = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $linhas = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $cash = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $conquista = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $atividade = null;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $data;

    #[ORM\Column(name: 'familia_codigo', type: 'string', length: 20, nullable: true)]
    private ?string $familiaCodigo = null;

    #[ORM\Column(name: 'indicador_codigo', type: 'string', length: 20, nullable: true)]
    private ?string $indicadorCodigo = null;

    #[ORM\Column(name: 'subindicador_codigo', type: 'string', length: 20, nullable: true)]
    private ?string $subindicadorCodigo = null;

    public function getCampanhaId(): string
    {
        return $this->campanhaId;
    }

    public function setCampanhaId(string $campanhaId): self
    {
        $this->campanhaId = $campanhaId;
        return $this;
    }

    public function getSprintId(): string
    {
        return $this->sprintId;
    }

    public function getDiretoriaId(): string
    {
        return $this->diretoriaId;
    }

    public function getDiretoriaNome(): string
    {
        return $this->diretoriaNome;
    }

    public function getGerenciaRegionalId(): string
    {
        return $this->gerenciaRegionalId;
    }

    public function getRegionalNome(): string
    {
        return $this->regionalNome;
    }

    public function getAgenciaId(): string
    {
        return $this->agenciaId;
    }

    public function getAgenciaNome(): string
    {
        return $this->agenciaNome;
    }

    public function getGerenteGestaoId(): ?string
    {
        return $this->gerenteGestaoId;
    }

    public function getGerenteGestaoNome(): ?string
    {
        return $this->gerenteGestaoNome;
    }

    public function getGerenteId(): ?string
    {
        return $this->gerenteId;
    }

    public function getGerenteNome(): ?string
    {
        return $this->gerenteNome;
    }

    public function getSegmento(): string
    {
        return $this->segmento;
    }

    public function getSegmentoId(): string
    {
        return $this->segmentoId;
    }

    public function getFamiliaId(): string
    {
        return $this->familiaId;
    }

    public function getIdIndicador(): string
    {
        return $this->idIndicador;
    }

    public function getDsIndicador(): string
    {
        return $this->dsIndicador;
    }

    public function getSubproduto(): ?string
    {
        return $this->subproduto;
    }

    public function getIdSubindicador(): string
    {
        return $this->idSubindicador;
    }

    public function getCarteira(): ?string
    {
        return $this->carteira;
    }

    public function getLinhas(): ?string
    {
        return $this->linhas;
    }

    public function getCash(): ?string
    {
        return $this->cash;
    }

    public function getConquista(): ?string
    {
        return $this->conquista;
    }

    public function getAtividade(): ?string
    {
        return $this->atividade;
    }

    public function getData(): \DateTimeInterface
    {
        return $this->data;
    }

    public function getFamiliaCodigo(): ?string
    {
        return $this->familiaCodigo;
    }

    public function getIndicadorCodigo(): ?string
    {
        return $this->indicadorCodigo;
    }

    public function getSubindicadorCodigo(): ?string
    {
        return $this->subindicadorCodigo;
    }
}

