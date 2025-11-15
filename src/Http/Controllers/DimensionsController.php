<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Repositories\EstruturaRepository;

class DimensionsController
{
    public function handle(array $params, $payload = null): void
    {
        $container = Container::getInstance();
        $repository = $container->get(EstruturaRepository::class);
        
        $result = [
            'dimSegmentos' => $repository->findAllSegmentos(),
            'dimDiretorias' => $repository->findAllDiretorias(),
            'dimRegionais' => $repository->findAllRegionais(),
            'dimAgencias' => $repository->findAllAgencias(),
            'dimGerentesGestao' => $repository->findAllGGestoes(),
            'dimGerentes' => $repository->findAllGerentes(),
            
            'segmentosDim' => $repository->findAllSegmentos(),
            'diretoriasDim' => $repository->findAllDiretorias(),
            'regionaisDim' => $repository->findAllRegionais(),
            'agenciasDim' => $repository->findAllAgencias(),
            'gerentesGestaoDim' => $repository->findAllGGestoes(),
            'gerentesDim' => $repository->findAllGerentes(),
            
            'segmentos' => $repository->findAllSegmentos(),
            'diretorias' => $repository->findAllDiretorias(),
            'regionais' => $repository->findAllRegionais(),
            'agencias' => $repository->findAllAgencias(),
            'ggestoes' => $repository->findAllGGestoes(),
            'gerentes' => $repository->findAllGerentes(),
        ];
        
        ResponseHelper::json($result);
    }
}

