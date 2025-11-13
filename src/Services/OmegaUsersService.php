<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\OmegaUsersRepository;

class OmegaUsersService
{
    private OmegaUsersRepository $repository;

    public function __construct(OmegaUsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllUsers(): array
    {
        return $this->repository->findAll();
    }
}

