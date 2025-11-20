<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\DetalhesRepository;

class DetalhesService
{
    private DetalhesRepository $repository;

    public function __construct(DetalhesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllDetalhes(): array
    {
        return $this->repository->findAllAsArray();
    }
}

