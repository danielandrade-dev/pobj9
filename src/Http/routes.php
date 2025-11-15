<?php

declare(strict_types=1);

use Pobj\Api\Enums\HttpMethod;
use Pobj\Api\Http\Router;
use Pobj\Api\Http\Controllers\AgentController;
use Pobj\Api\Http\Controllers\InitDataController;
use Pobj\Api\Http\Controllers\FiltrosController;
use Pobj\Api\Http\Controllers\HealthController;
use Pobj\Api\Http\Controllers\OmegaMesuController;
use Pobj\Api\Http\Controllers\OmegaStatusController;
use Pobj\Api\Http\Controllers\OmegaStructureController;
use Pobj\Api\Http\Controllers\OmegaTicketsController;
use Pobj\Api\Http\Controllers\OmegaUsersController;
use Pobj\Api\Http\Controllers\ResumoController;
use Pobj\Api\Http\Controllers\StatusIndicadoresController;

return function (Router $router): void {
    $router->group('api', function ($router) {
        $router->add('health', HealthController::class, 'check', [HttpMethod::GET->value]);
        $router->add('agent', AgentController::class, 'handle', [HttpMethod::POST->value]);
        $router->add('init-data', InitDataController::class, 'handle', [HttpMethod::GET->value]);
        $router->add('filtros', FiltrosController::class, 'handle', [HttpMethod::GET->value]);
        $router->add('resumo', ResumoController::class, 'handle', [HttpMethod::GET->value]);
        $router->add('status_indicadores', StatusIndicadoresController::class, 'handle', [HttpMethod::GET->value]);
        
        $router->group('omega', function ($router) {
            $router->add('users', OmegaUsersController::class, 'handle', [HttpMethod::GET->value]);
            $router->add('statuses', OmegaStatusController::class, 'handle', [HttpMethod::GET->value]);
            $router->add('structure', OmegaStructureController::class, 'handle', [HttpMethod::GET->value]);
            $router->add('tickets', OmegaTicketsController::class, 'handle', [HttpMethod::GET->value]);
            $router->add('mesu', OmegaMesuController::class, 'handle', [HttpMethod::GET->value]);
        });
    });
};
