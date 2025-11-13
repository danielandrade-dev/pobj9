<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\OmegaStructureService;

class OmegaStructureController
{
    public function handle(array $params, $payload = null): void
    {
        try {
            $container = Container::getInstance();
            $service = $container->get(OmegaStructureService::class);
            $result = $service->getStructure();
            ResponseHelper::json($result);
        } catch (\Throwable $e) {
            \Pobj\Api\Helpers\Logger::exception($e, [
                'endpoint' => 'omega/structure',
            ]);
            ResponseHelper::error('Erro ao carregar estrutura Omega: ' . $e->getMessage(), HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        }
    }
}

