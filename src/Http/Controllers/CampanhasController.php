<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Repositories\CampanhasRepository;

class CampanhasController
{
    public function handle(array $params, $payload = null): void
    {
        $container = Container::getInstance();
        $repository = $container->get(CampanhasRepository::class);
        $result = $repository->findAllAsArray();
        ResponseHelper::json($result);
    }
}

