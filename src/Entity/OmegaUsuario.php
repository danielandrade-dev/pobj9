<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'omega_usuarios')]
class OmegaUsuario
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 40)]
    private string $id;

    #[ORM\Column(type: 'string', length: 150)]
    private string $nome;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $funcional = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $matricula = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $cargo = null;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $usuario = true;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $analista = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $supervisor = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $admin = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $encarteiramento = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $meta = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $orcamento = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $pobj = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $matriz = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $outros = false;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getFuncional(): ?string
    {
        return $this->funcional;
    }

    public function setFuncional(?string $funcional): self
    {
        $this->funcional = $funcional;
        return $this;
    }

    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    public function setMatricula(?string $matricula): self
    {
        $this->matricula = $matricula;
        return $this;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(?string $cargo): self
    {
        $this->cargo = $cargo;
        return $this;
    }

    public function isUsuario(): bool
    {
        return $this->usuario;
    }

    public function setUsuario(bool $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function isAnalista(): bool
    {
        return $this->analista;
    }

    public function setAnalista(bool $analista): self
    {
        $this->analista = $analista;
        return $this;
    }

    public function isSupervisor(): bool
    {
        return $this->supervisor;
    }

    public function setSupervisor(bool $supervisor): self
    {
        $this->supervisor = $supervisor;
        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;
        return $this;
    }

    public function isEncarteiramento(): bool
    {
        return $this->encarteiramento;
    }

    public function setEncarteiramento(bool $encarteiramento): self
    {
        $this->encarteiramento = $encarteiramento;
        return $this;
    }

    public function isMeta(): bool
    {
        return $this->meta;
    }

    public function setMeta(bool $meta): self
    {
        $this->meta = $meta;
        return $this;
    }

    public function isOrcamento(): bool
    {
        return $this->orcamento;
    }

    public function setOrcamento(bool $orcamento): self
    {
        $this->orcamento = $orcamento;
        return $this;
    }

    public function isPobj(): bool
    {
        return $this->pobj;
    }

    public function setPobj(bool $pobj): self
    {
        $this->pobj = $pobj;
        return $this;
    }

    public function isMatriz(): bool
    {
        return $this->matriz;
    }

    public function setMatriz(bool $matriz): self
    {
        $this->matriz = $matriz;
        return $this;
    }

    public function isOutros(): bool
    {
        return $this->outros;
    }

    public function setOutros(bool $outros): self
    {
        $this->outros = $outros;
        return $this;
    }
}

