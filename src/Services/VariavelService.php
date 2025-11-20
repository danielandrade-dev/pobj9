<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\VariavelRepository;

class VariavelService
{
    private VariavelRepository $repository;

    public function __construct(VariavelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllVariaveis(): array
    {
        return $this->repository->findAllAsArray();
    }
}

