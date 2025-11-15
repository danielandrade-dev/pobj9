<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_detalhes')]
class FDetalhes
{
    #[ORM\Id]
    #[ORM\Column(name: 'contrato_id', type: 'string', length: 80)]
    private string $contratoId;

    #[ORM\Column(name: 'registro_id', type: 'string', length: 60)]
    private string $registroId;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $segmento = null;

    #[ORM\Column(name: 'segmento_id', type: 'string', length: 50)]
    private string $segmentoId;

    #[ORM\Column(name: 'diretoria_id', type: 'string', length: 50)]
    private string $diretoriaId;

    #[ORM\Column(name: 'diretoria_nome', type: 'string', length: 150, nullable: true)]
    private ?string $diretoriaNome = null;

    #[ORM\Column(name: 'gerencia_regional_id', type: 'string', length: 50)]
    private string $gerenciaRegionalId;

    #[ORM\Column(name: 'gerencia_regional_nome', type: 'string', length: 150, nullable: true)]
    private ?string $gerenciaRegionalNome = null;

    #[ORM\Column(name: 'agencia_id', type: 'string', length: 50)]
    private string $agenciaId;

    #[ORM\Column(name: 'agencia_nome', type: 'string', length: 150, nullable: true)]
    private ?string $agenciaNome = null;

    #[ORM\Column(name: 'gerente_gestao_id', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteGestaoId = null;

    #[ORM\Column(name: 'gerente_gestao_nome', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteGestaoNome = null;

    #[ORM\Column(name: 'gerente_id', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteId = null;

    #[ORM\Column(name: 'gerente_nome', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteNome = null;

    #[ORM\Column(name: 'familia_id', type: 'string', length: 20)]
    private string $familiaId;

    #[ORM\Column(name: 'familia_nome', type: 'string', length: 150, nullable: true)]
    private ?string $familiaNome = null;

    #[ORM\Column(name: 'id_indicador', type: 'string', length: 80)]
    private string $idIndicador;

    #[ORM\Column(name: 'ds_indicador', type: 'string', length: 150, nullable: true)]
    private ?string $dsIndicador = null;

    #[ORM\Column(name: 'id_subindicador', type: 'string', length: 80, options: ['default' => '0'])]
    private string $idSubindicador = '0';

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $subindicador = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $carteira = null;

    #[ORM\Column(name: 'canal_venda', type: 'string', length: 150, nullable: true)]
    private ?string $canalVenda = null;

    #[ORM\Column(name: 'tipo_venda', type: 'string', length: 100, nullable: true)]
    private ?string $tipoVenda = null;

    #[ORM\Column(name: 'modalidade_pagamento', type: 'string', length: 100, nullable: true)]
    private ?string $modalidadePagamento = null;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $data;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $competencia;

    #[ORM\Column(name: 'valor_meta', type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $valorMeta = null;

    #[ORM\Column(name: 'valor_realizado', type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $valorRealizado = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 4, nullable: true)]
    private ?string $quantidade = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 4, nullable: true)]
    private ?string $peso = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 4, nullable: true)]
    private ?string $pontos = null;

    #[ORM\Column(name: 'data_vencimento', type: 'date', nullable: true)]
    private ?\DateTimeInterface $dataVencimento = null;

    #[ORM\Column(name: 'data_cancelamento', type: 'date', nullable: true)]
    private ?\DateTimeInterface $dataCancelamento = null;

    #[ORM\Column(name: 'motivo_cancelamento', type: 'string', length: 255, nullable: true)]
    private ?string $motivoCancelamento = null;

    #[ORM\Column(name: 'status_id', type: 'string', length: 20, nullable: true)]
    private ?string $statusId = null;

    public function getContratoId(): string
    {
        return $this->contratoId;
    }

    public function setContratoId(string $contratoId): self
    {
        $this->contratoId = $contratoId;
        return $this;
    }

    public function getRegistroId(): string
    {
        return $this->registroId;
    }

    public function getSegmento(): ?string
    {
        return $this->segmento;
    }

    public function getSegmentoId(): string
    {
        return $this->segmentoId;
    }

    public function getDiretoriaId(): string
    {
        return $this->diretoriaId;
    }

    public function getDiretoriaNome(): ?string
    {
        return $this->diretoriaNome;
    }

    public function getGerenciaRegionalId(): string
    {
        return $this->gerenciaRegionalId;
    }

    public function getGerenciaRegionalNome(): ?string
    {
        return $this->gerenciaRegionalNome;
    }

    public function getAgenciaId(): string
    {
        return $this->agenciaId;
    }

    public function getAgenciaNome(): ?string
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

    public function getFamiliaId(): string
    {
        return $this->familiaId;
    }

    public function getFamiliaNome(): ?string
    {
        return $this->familiaNome;
    }

    public function getIdIndicador(): string
    {
        return $this->idIndicador;
    }

    public function getDsIndicador(): ?string
    {
        return $this->dsIndicador;
    }

    public function getIdSubindicador(): string
    {
        return $this->idSubindicador;
    }

    public function getSubindicador(): ?string
    {
        return $this->subindicador;
    }

    public function getCarteira(): ?string
    {
        return $this->carteira;
    }

    public function getCanalVenda(): ?string
    {
        return $this->canalVenda;
    }

    public function getTipoVenda(): ?string
    {
        return $this->tipoVenda;
    }

    public function getModalidadePagamento(): ?string
    {
        return $this->modalidadePagamento;
    }

    public function getData(): \DateTimeInterface
    {
        return $this->data;
    }

    public function getCompetencia(): \DateTimeInterface
    {
        return $this->competencia;
    }

    public function getValorMeta(): ?string
    {
        return $this->valorMeta;
    }

    public function getValorRealizado(): ?string
    {
        return $this->valorRealizado;
    }

    public function getQuantidade(): ?string
    {
        return $this->quantidade;
    }

    public function getPeso(): ?string
    {
        return $this->peso;
    }

    public function getPontos(): ?string
    {
        return $this->pontos;
    }

    public function getStatusId(): ?string
    {
        return $this->statusId;
    }
}

