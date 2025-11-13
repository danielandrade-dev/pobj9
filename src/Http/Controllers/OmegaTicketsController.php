<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\OmegaTicketsService;

class OmegaTicketsController
{
    public function handle(array $params, $payload = null): void
    {
        try {
            $container = Container::getInstance();
            $service = $container->get(OmegaTicketsService::class);
            $result = $service->getAllTickets();
            ResponseHelper::json($result);
        } catch (\Throwable $e) {
            \Pobj\Api\Helpers\Logger::exception($e, [
                'endpoint' => 'omega/tickets',
            ]);
            ResponseHelper::error('Erro ao carregar chamados Omega: ' . $e->getMessage(), HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        }
    }
}

