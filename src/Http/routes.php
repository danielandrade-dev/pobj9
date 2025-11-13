<?php

declare(strict_types=1);

use Pobj\Api\Http\Router;
use Pobj\Api\Http\Controllers\AgentController;
use Pobj\Api\Http\Controllers\BootstrapController;
use Pobj\Api\Http\Controllers\FiltrosController;
use Pobj\Api\Http\Controllers\HealthController;
use Pobj\Api\Http\Controllers\ResumoController;
use Pobj\Api\Http\Controllers\StatusIndicadoresController;

return function (Router $router): void {
    $router->add('health', HealthController::class, 'check', ['GET']);

    $router->add('agent', AgentController::class, 'handle', ['POST']);

    $router->add('bootstrap', BootstrapController::class, 'handle', ['GET']);

    $router->add('filtros', FiltrosController::class, 'handle', ['GET']);

    $router->add('resumo', ResumoController::class, 'handle', ['GET']);

    $router->add('status_indicadores', StatusIndicadoresController::class, 'handle', ['GET']);
};
