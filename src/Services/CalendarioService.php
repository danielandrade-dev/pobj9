<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\CalendarioRepository;

class CalendarioService
{
    private CalendarioRepository $repository;

    public function __construct(CalendarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllCalendario(): array
    {
        return $this->repository->findAllAsArray();
    }
}

