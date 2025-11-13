<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_metas')]
class FMeta
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 60)]
    private string $registroId;

    #[ORM\Column(type: 'string', length: 100)]
    private string $segmento;

    #[ORM\Column(type: 'string', length: 50)]
    private string $segmentoId;

    #[ORM\Column(type: 'string', length: 50)]
    private string $diretoriaId;

    #[ORM\Column(type: 'string', length: 150)]
    private string $diretoriaNome;

    #[ORM\Column(type: 'string', length: 50)]
    private string $gerenciaRegionalId;

    #[ORM\Column(type: 'string', length: 150)]
    private string $gerenciaRegionalNome;

    #[ORM\Column(type: 'string', length: 150)]
    private string $regionalNome;

    #[ORM\Column(type: 'string', length: 50)]
    private string $agenciaId;

    #[ORM\Column(type: 'string', length: 150)]
    private string $agenciaNome;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $gerenteGestaoId = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $gerenteGestaoNome = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $gerenteId = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $gerenteNome = null;

    #[ORM\Column(type: 'string', length: 20)]
    private string $familiaId;

    #[ORM\Column(type: 'string', length: 150)]
    private string $familiaNome;

    #[ORM\Column(type: 'string', length: 80)]
    private string $idIndicador;

    #[ORM\Column(type: 'string', length: 150)]
    private string $dsIndicador;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $subproduto = null;

    #[ORM\Column(type: 'string', length: 80, options: ['default' => '0'])]
    private string $idSubindicador = '0';

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $carteira = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $canalVenda = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $tipoVenda = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $modalidadePagamento = null;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $data;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $competencia;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2)]
    private string $metaMensal;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $metaAcumulada = null;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, nullable: true)]
    private ?string $variavelMeta = null;

    #[ORM\Column(type: 'decimal', precision: 9, scale: 4, nullable: true)]
    private ?string $peso = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $familiaCodigo = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $indicadorCodigo = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
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

