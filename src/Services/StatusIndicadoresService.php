<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\StatusIndicadoresRepository;

class StatusIndicadoresService
{
    private StatusIndicadoresRepository $statusRepository;

    public function __construct(StatusIndicadoresRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function getAllStatus(): array
    {
        return ['rows' => $this->statusRepository->findAllAsArray()];
    }
}

