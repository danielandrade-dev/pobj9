<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'omega_chamados')]
class OmegaChamado
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 60)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $subject = null;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(type: 'string', length: 80, nullable: true)]
    private ?string $productId = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $productLabel = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $family = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $section = null;

    #[ORM\Column(type: 'string', length: 120, nullable: true)]
    private ?string $queue = null;

    #[ORM\Column(type: 'string', length: 120, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private ?string $priority = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $opened = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private ?string $requesterId = null;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private ?string $ownerId = null;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private ?string $teamId = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $history = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $diretoria = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $gerencia = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $agencia = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $gerenteGestao = null;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private ?string $gerente = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $credit = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $attachment = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getProductLabel(): ?string
    {
        return $this->productLabel;
    }

    public function setProductLabel(?string $productLabel): self
    {
        $this->productLabel = $productLabel;
        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(?string $family): self
    {
        $this->family = $family;
        return $this;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(?string $section): self
    {
        $this->section = $section;
        return $this;
    }

    public function getQueue(): ?string
    {
        return $this->queue;
    }

    public function setQueue(?string $queue): self
    {
        $this->queue = $queue;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getOpened(): ?\DateTimeInterface
    {
        return $this->opened;
    }

    public function setOpened(?\DateTimeInterface $opened): self
    {
        $this->opened = $opened;
        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getRequesterId(): ?string
    {
        return $this->requesterId;
    }

    public function setRequesterId(?string $requesterId): self
    {
        $this->requesterId = $requesterId;
        return $this;
    }

    public function getOwnerId(): ?string
    {
        return $this->ownerId;
    }

    public function setOwnerId(?string $ownerId): self
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    public function getTeamId(): ?string
    {
        return $this->teamId;
    }

    public function setTeamId(?string $teamId): self
    {
        $this->teamId = $teamId;
        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(?string $history): self
    {
        $this->history = $history;
        return $this;
    }

    public function getDiretoria(): ?string
    {
        return $this->diretoria;
    }

    public function setDiretoria(?string $diretoria): self
    {
        $this->diretoria = $diretoria;
        return $this;
    }

    public function getGerencia(): ?string
    {
        return $this->gerencia;
    }

    public function setGerencia(?string $gerencia): self
    {
        $this->gerencia = $gerencia;
        return $this;
    }

    public function getAgencia(): ?string
    {
        return $this->agencia;
    }

    public function setAgencia(?string $agencia): self
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

    public function getGerente(): ?string
    {
        return $this->gerente;
    }

    public function setGerente(?string $gerente): self
    {
        $this->gerente = $gerente;
        return $this;
    }

    public function getCredit(): ?string
    {
        return $this->credit;
    }

    public function setCredit(?string $credit): self
    {
        $this->credit = $credit;
        return $this;
    }

    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    public function setAttachment(?string $attachment): self
    {
        $this->attachment = $attachment;
        return $this;
    }
}

