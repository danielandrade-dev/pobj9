<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\HistoricoRepository;

class HistoricoService
{
    private HistoricoRepository $repository;

    public function __construct(HistoricoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllHistorico(): array
    {
        return $this->repository->findAllAsArray();
    }
}

