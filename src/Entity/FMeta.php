<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_metas')]
class FMeta
{
    #[ORM\Id]
    #[ORM\Column(name: 'registro_id', type: 'string', length: 60)]
    private string $registroId;

    #[ORM\Column(type: 'string', length: 100)]
    private string $segmento;

    #[ORM\Column(name: 'segmento_id', type: 'string', length: 50)]
    private string $segmentoId;

    #[ORM\Column(name: 'diretoria_id', type: 'string', length: 50)]
    private string $diretoriaId;

    #[ORM\Column(name: 'diretoria_nome', type: 'string', length: 150)]
    private string $diretoriaNome;

    #[ORM\Column(name: 'gerencia_regional_id', type: 'string', length: 50)]
    private string $gerenciaRegionalId;

    #[ORM\Column(name: 'gerencia_regional_nome', type: 'string', length: 150)]
    private string $gerenciaRegionalNome;

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

    #[ORM\Column(name: 'familia_id', type: 'string', length: 20)]
    private string $familiaId;

    #[ORM\Column(name: 'familia_nome', type: 'string', length: 150)]
    private string $familiaNome;

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

    #[ORM\Column(name: 'meta_mensal', type: 'decimal', precision: 18, scale: 2)]
    private string $metaMensal;

    #[ORM\Column(name: 'meta_acumulada', type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $metaAcumulada = null;

    #[ORM\Column(name: 'variavel_meta', type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $variavelMeta = null;

    #[ORM\Column(type: 'decimal', precision: 9, scale: 4, nullable: true)]
    private ?string $peso = null;

    #[ORM\Column(name: 'familia_codigo', type: 'string', length: 20, nullable: true)]
    private ?string $familiaCodigo = null;

    #[ORM\Column(name: 'indicador_codigo', type: 'string', length: 20, nullable: true)]
    private ?string $indicadorCodigo = null;

    #[ORM\Column(name: 'subindicador_codigo', type: 'string', length: 20, nullable: true)]
    private ?string $subindicadorCodigo = null;

    public function getRegistroId(): string
    {
        return $this->registroId;
    }

    public function setRegistroId(string $registroId): self
    {
        $this->registroId = $registroId;
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

    public function getData(): \DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getIdIndicador(): string
    {
        return $this->idIndicador;
    }

    public function setIdIndicador(string $idIndicador): self
    {
        $this->idIndicador = $idIndicador;
        return $this;
    }
}
