<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\OmegaUsersService;

class OmegaUsersController
{
    public function handle(array $params, $payload = null): void
    {
        try {
            $container = Container::getInstance();
            $service = $container->get(OmegaUsersService::class);
            $result = $service->getAllUsers();
            ResponseHelper::json($result);
        } catch (\Throwable $e) {
            \Pobj\Api\Helpers\Logger::exception($e, [
                'endpoint' => 'omega/users',
            ]);
            ResponseHelper::error('Erro ao carregar usuários Omega: ' . $e->getMessage(), 500);
        }
    }
}

