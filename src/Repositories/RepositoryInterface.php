<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;

interface RepositoryInterface
{
    public function __construct(EntityManager $entityManager);
}

