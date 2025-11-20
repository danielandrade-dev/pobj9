<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\LeadsRepository;

class LeadsService
{
    private LeadsRepository $repository;

    public function __construct(LeadsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllLeads(): array
    {
        return $this->repository->findAllAsArray();
    }
}

