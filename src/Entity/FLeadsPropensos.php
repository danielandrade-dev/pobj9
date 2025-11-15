<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_leads_propensos')]
class FLeadsPropensos
{
    #[ORM\Id]
    #[ORM\Column(type: 'date_immutable')]
    private \DateTimeImmutable $database;

    #[ORM\Id]
    #[ORM\Column(name: 'nome_empresa', type: 'string', length: 200)]
    private string $nomeEmpresa;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $cnae = null;

    #[ORM\Column(name: 'segmento_cliente', type: 'string', length: 100, nullable: true)]
    private ?string $segmentoCliente = null;

    #[ORM\Column(name: 'segmento_cliente_id', type: 'string', length: 50, nullable: true)]
    private ?string $segmentoClienteId = null;

    #[ORM\Column(name: 'produto_propenso', type: 'string', length: 150)]
    private string $produtoPropenso;

    #[ORM\Column(name: 'familia_produto_propenso', type: 'string', length: 150)]
    private string $familiaProdutoPropenso;

    #[ORM\Column(name: 'secao_produto_propenso', type: 'string', length: 150, nullable: true)]
    private ?string $secaoProdutoPropenso = null;

    #[ORM\Column(name: 'id_indicador', type: 'string', length: 80, nullable: true)]
    private ?string $idIndicador = null;

    #[ORM\Column(name: 'id_subindicador', type: 'string', length: 80, options: ['default' => '0'])]
    private string $idSubindicador = '0';

    #[ORM\Column(name: 'data_contato', type: 'date', nullable: true)]
    private ?\DateTimeInterface $dataContato = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comentario = null;

    #[ORM\Column(name: 'responsavel_contato', type: 'string', length: 150, nullable: true)]
    private ?string $responsavelContato = null;

    #[ORM\Column(name: 'diretoria_cliente', type: 'string', length: 150, nullable: true)]
    private ?string $diretoriaCliente = null;

    #[ORM\Column(name: 'diretoria_cliente_id', type: 'string', length: 50, nullable: true)]
    private ?string $diretoriaClienteId = null;

    #[ORM\Column(name: 'regional_cliente', type: 'string', length: 150, nullable: true)]
    private ?string $regionalCliente = null;

    #[ORM\Column(name: 'regional_cliente_id', type: 'string', length: 50, nullable: true)]
    private ?string $regionalClienteId = null;

    #[ORM\Column(name: 'agencia_cliente', type: 'string', length: 150, nullable: true)]
    private ?string $agenciaCliente = null;

    #[ORM\Column(name: 'agencia_cliente_id', type: 'string', length: 50, nullable: true)]
    private ?string $agenciaClienteId = null;

    #[ORM\Column(name: 'gerente_gestao_cliente', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteGestaoCliente = null;

    #[ORM\Column(name: 'gerente_gestao_cliente_id', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteGestaoClienteId = null;

    #[ORM\Column(name: 'gerente_cliente', type: 'string', length: 150, nullable: true)]
    private ?string $gerenteCliente = null;

    #[ORM\Column(name: 'gerente_cliente_id', type: 'string', length: 50, nullable: true)]
    private ?string $gerenteClienteId = null;

    #[ORM\Column(name: 'credito_pre_aprovado', type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $creditoPreAprovado = null;

    #[ORM\Column(name: 'origem_lead', type: 'string', length: 50, nullable: true)]
    private ?string $origemLead = null;

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
        return $this->database->format('Y-m-d') . '_' . $this->nomeEmpresa;
    }

    public function getNomeEmpresa(): string
    {
        return $this->nomeEmpresa;
    }

    public function getCnae(): ?string
    {
        return $this->cnae;
    }

    public function getSegmentoCliente(): ?string
    {
        return $this->segmentoCliente;
    }

    public function getSegmentoClienteId(): ?string
    {
        return $this->segmentoClienteId;
    }

    public function getProdutoPropenso(): string
    {
        return $this->produtoPropenso;
    }

    public function getFamiliaProdutoPropenso(): string
    {
        return $this->familiaProdutoPropenso;
    }

    public function getSecaoProdutoPropenso(): ?string
    {
        return $this->secaoProdutoPropenso;
    }

    public function getIdIndicador(): ?string
    {
        return $this->idIndicador;
    }

    public function getIdSubindicador(): string
    {
        return $this->idSubindicador;
    }

    public function getDataContato(): ?\DateTimeInterface
    {
        return $this->dataContato;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function getResponsavelContato(): ?string
    {
        return $this->responsavelContato;
    }

    public function getDiretoriaCliente(): ?string
    {
        return $this->diretoriaCliente;
    }

    public function getDiretoriaClienteId(): ?string
    {
        return $this->diretoriaClienteId;
    }

    public function getRegionalCliente(): ?string
    {
        return $this->regionalCliente;
    }

    public function getRegionalClienteId(): ?string
    {
        return $this->regionalClienteId;
    }

    public function getAgenciaCliente(): ?string
    {
        return $this->agenciaCliente;
    }

    public function getAgenciaClienteId(): ?string
    {
        return $this->agenciaClienteId;
    }

    public function getGerenteGestaoCliente(): ?string
    {
        return $this->gerenteGestaoCliente;
    }

    public function getGerenteGestaoClienteId(): ?string
    {
        return $this->gerenteGestaoClienteId;
    }

    public function getGerenteCliente(): ?string
    {
        return $this->gerenteCliente;
    }

    public function getGerenteClienteId(): ?string
    {
        return $this->gerenteClienteId;
    }

    public function getCreditoPreAprovado(): ?string
    {
        return $this->creditoPreAprovado;
    }

    public function getOrigemLead(): ?string
    {
        return $this->origemLead;
    }
}

