<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\OmegaMesuService;

class OmegaMesuController
{
    public function handle(array $params, $payload = null): void
    {
        try {
            $container = Container::getInstance();
            $service = $container->get(OmegaMesuService::class);
            $result = $service->getMesuData();
            ResponseHelper::json($result);
        } catch (\Throwable $e) {
            \Pobj\Api\Helpers\Logger::exception($e, [
                'endpoint' => 'omega/mesu',
            ]);
            ResponseHelper::error('Erro ao carregar dados MESU: ' . $e->getMessage(), HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        }
    }
}

