<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'f_variavel')]
class FVariavel
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private int $id;

    #[ORM\Column(type: 'string', length: 20)]
    private string $funcional;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, options: ['default' => '0.00'])]
    private string $meta;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 2, options: ['default' => '0.00'])]
    private string $variavel;

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

    public function getMeta(): string
    {
        return $this->meta;
    }

    public function setMeta(string $meta): self
    {
        $this->meta = $meta;
        return $this;
    }

    public function getVariavel(): string
    {
        return $this->variavel;
    }

    public function setVariavel(string $variavel): self
    {
        $this->variavel = $variavel;
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

