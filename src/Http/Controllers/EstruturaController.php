<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Repositories\EstruturaRepository;

class EstruturaController
{
    public function handle(array $params, $payload = null): void
    {
        $repo = Container::getInstance()->get(EstruturaRepository::class);
    
        $result = [
            'segmentos'       => $repo->findAllSegmentos(),
            'diretorias'      => $repo->findAllDiretorias(),
            'regionais'       => $repo->findAllRegionais(),
            'agencias'        => $repo->findAllAgencias(),
            'gerentes_gestao' => $repo->findAllGGestoes(),
            'gerentes'        => $repo->findAllGerentes(),
        ];
    
        ResponseHelper::json($result);
    }
}

