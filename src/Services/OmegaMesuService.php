<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\OmegaMesuRepository;

class OmegaMesuService
{
    private OmegaMesuRepository $repository;

    public function __construct(OmegaMesuRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getMesuData(): array
    {
        return $this->repository->findAll();
    }
}

