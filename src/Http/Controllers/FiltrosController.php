<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Enums\FiltroNivel;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\FiltrosService;

class FiltrosController
{
    public function handle(array $params, $payload = null): void
    {
        $nivelStr = $params['nivel'] ?? '';
        if (empty($nivelStr)) {
            ResponseHelper::error('Parâmetro "nivel" é obrigatório', HttpStatusCode::BAD_REQUEST->value);
        }

        $nivel = FiltroNivel::tryFromString($nivelStr);
        if ($nivel === null) {
            ResponseHelper::error('Nível inválido: ' . $nivelStr, HttpStatusCode::BAD_REQUEST->value);
        }

        $container = Container::getInstance();
        $service = $container->get(FiltrosService::class);
        $result = $service->getFiltroByNivel($nivel);
        ResponseHelper::json($result);
    }
}
