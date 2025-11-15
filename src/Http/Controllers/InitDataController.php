<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\InitDataService;

class InitDataController
{
    public function handle(array $params, $payload = null): void
    {
        $container = Container::getInstance();
        $service = $container->get(InitDataService::class);
        $result = $service->getInitData();
        ResponseHelper::json($result);
    }
}

