<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\OmegaTicketsRepository;

class OmegaTicketsService
{
    private OmegaTicketsRepository $repository;

    public function __construct(OmegaTicketsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTickets(): array
    {
        return $this->repository->findAll();
    }
}

