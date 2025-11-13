<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\ResumoService;

class ResumoController
{
    public function handle(array $params, $payload = null): void
    {
        try {
            $container = Container::getInstance();
            $service = $container->get(ResumoService::class);
            $result = $service->getResumo($params);
            ResponseHelper::json($result);
        } catch (\InvalidArgumentException $e) {
            ResponseHelper::error($e->getMessage(), HttpStatusCode::BAD_REQUEST->value);
        }
    }
}
}
