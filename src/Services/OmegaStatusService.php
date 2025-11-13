<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\OmegaStatusRepository;

class OmegaStatusService
{
    private OmegaStatusRepository $repository;

    public function __construct(OmegaStatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllStatus(): array
    {
        return $this->repository->findAllAsArray();
    }
}

