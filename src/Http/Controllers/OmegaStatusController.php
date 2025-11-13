<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\OmegaStatusService;

class OmegaStatusController
{
    public function handle(array $params, $payload = null): void
    {
        try {
            $container = Container::getInstance();
            $service = $container->get(OmegaStatusService::class);
            $result = $service->getAllStatus();
            ResponseHelper::json($result);
        } catch (\Throwable $e) {
            \Pobj\Api\Helpers\Logger::exception($e, [
                'endpoint' => 'omega/statuses',
            ]);
            ResponseHelper::error('Erro ao carregar status Omega: ' . $e->getMessage(), HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        }
    }
}

