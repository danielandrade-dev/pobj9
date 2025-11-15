<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Repositories\DetalhesRepository;

class DetalhesController
{
    public function handle(array $params, $payload = null): void
    {
        $container = Container::getInstance();
        $repository = $container->get(DetalhesRepository::class);
        $result = $repository->findAllAsArray();
        ResponseHelper::json($result);
    }
}

