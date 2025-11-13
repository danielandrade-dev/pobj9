<?php

declare(strict_types=1);

use Pobj\Api\Enums\HttpMethod;
use Pobj\Api\Http\Router;
use Pobj\Api\Http\Controllers\AgentController;
use Pobj\Api\Http\Controllers\BootstrapController;
use Pobj\Api\Http\Controllers\FiltrosController;
use Pobj\Api\Http\Controllers\HealthController;
use Pobj\Api\Http\Controllers\ResumoController;
use Pobj\Api\Http\Controllers\StatusIndicadoresController;

return function (Router $router): void {
    $router->add('health', HealthController::class, 'check', [HttpMethod::GET->value]);

    $router->add('agent', AgentController::class, 'handle', [HttpMethod::POST->value]);

    $router->add('bootstrap', BootstrapController::class, 'handle', [HttpMethod::GET->value]);

    $router->add('filtros', FiltrosController::class, 'handle', [HttpMethod::GET->value]);

    $router->add('resumo', ResumoController::class, 'handle', [HttpMethod::GET->value]);

    $router->add('status_indicadores', StatusIndicadoresController::class, 'handle', [HttpMethod::GET->value]);
};
