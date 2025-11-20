<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\RealizadoRepository;

class RealizadoService
{
    private RealizadoRepository $repository;

    public function __construct(RealizadoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllRealizados(): array
    {
        return $this->repository->findAllAsArray();
    }
}

