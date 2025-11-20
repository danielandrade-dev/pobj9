<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\MetaRepository;

class MetaService
{
    private MetaRepository $repository;

    public function __construct(MetaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllMetas(): array
    {
        return $this->repository->findAllAsArray();
    }
}

