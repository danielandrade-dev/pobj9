<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\CampanhasRepository;

class CampanhasService
{
    private CampanhasRepository $repository;

    public function __construct(CampanhasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllCampanhas(): array
    {
        return $this->repository->findAllAsArray();
    }
}

