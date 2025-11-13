<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\OmegaStructureRepository;

class OmegaStructureService
{
    private OmegaStructureRepository $repository;

    public function __construct(OmegaStructureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getStructure(): array
    {
        return $this->repository->findAllAsArray();
    }
}

