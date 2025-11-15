<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class OmegaTicketDTO
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $subject = null,
        public readonly ?string $company = null,
        public readonly ?string $productId = null,
        public readonly ?string $productLabel = null,
        public readonly ?string $family = null,
        public readonly ?string $section = null,
        public readonly ?string $queue = null,
        public readonly ?string $category = null,
        public readonly ?string $status = null,
        public readonly ?string $priority = null,
        public readonly ?string $opened = null,
        public readonly ?string $updated = null,
        public readonly ?string $dueDate = null,
        public readonly ?string $requesterId = null,
        public readonly ?string $ownerId = null,
        public readonly ?string $teamId = null,
        public readonly ?string $history = null,
        public readonly ?string $diretoria = null,
        public readonly ?string $gerencia = null,
        public readonly ?string $agencia = null,
        public readonly ?string $gerenteGestao = null,
        public readonly ?string $gerente = null,
        public readonly ?string $credit = null,
        public readonly ?string $attachment = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'company' => $this->company,
            'product_id' => $this->productId,
            'product_label' => $this->productLabel,
            'family' => $this->family,
            'section' => $this->section,
            'queue' => $this->queue,
            'category' => $this->category,
            'status' => $this->status,
            'priority' => $this->priority,
            'opened' => $this->opened,
            'updated' => $this->updated,
            'due_date' => $this->dueDate,
            'requester_id' => $this->requesterId,
            'owner_id' => $this->ownerId,
            'team_id' => $this->teamId,
            'history' => $this->history,
            'diretoria' => $this->diretoria,
            'gerencia' => $this->gerencia,
            'agencia' => $this->agencia,
            'gerente_gestao' => $this->gerenteGestao,
            'gerente' => $this->gerente,
            'credit' => $this->credit,
            'attachment' => $this->attachment,
        ];
    }
}

