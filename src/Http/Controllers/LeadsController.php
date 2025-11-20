<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\LeadsService;

class LeadsController
{
    public function handle(array $params, $payload = null): void
    {
        $container = Container::getInstance();
        $service = $container->get(LeadsService::class);
        $result = $service->getAllLeads();
        ResponseHelper::json($result);
    }
}

