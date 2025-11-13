<?php

declare(strict_types=1);

use Pobj\Api\Http\Router;
use Pobj\Api\Http\Controllers\AgentController;
use Pobj\Api\Http\Controllers\BootstrapController;
use Pobj\Api\Http\Controllers\FiltrosController;
use Pobj\Api\Http\Controllers\HealthController;
use Pobj\Api\Http\Controllers\ResumoController;
use Pobj\Api\Http\Controllers\StatusIndicadoresController;

/**
 * Configuração de rotas da API
 *
 * @param Router $router
 */
return function (Router $router): void {
    // Health check
    $router->add('health', HealthController::class, 'check', ['GET']);

    // Agente de IA
    $router->add('agent', AgentController::class, 'handle', ['POST']);

    // Bootstrap (dados iniciais)
    $router->add('bootstrap', BootstrapController::class, 'handle', ['GET']);

    // Filtros
    $router->add('filtros', FiltrosController::class, 'handle', ['GET']);

    // Resumo
    $router->add('resumo', ResumoController::class, 'handle', ['GET']);

    // Status de indicadores
    $router->add('status_indicadores', StatusIndicadoresController::class, 'handle', ['GET']);
};

