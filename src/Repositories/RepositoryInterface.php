<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;

interface RepositoryInterface
{
    public function __construct(PDO $pdo);
}

