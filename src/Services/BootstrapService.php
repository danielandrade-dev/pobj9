<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\EstruturaRepository;
use Pobj\Api\Repositories\StatusIndicadoresRepository;

class BootstrapService
{
    private EstruturaRepository $estruturaRepository;
    private StatusIndicadoresRepository $statusRepository;

    public function __construct(
        EstruturaRepository $estruturaRepository,
        StatusIndicadoresRepository $statusRepository
    ) {
        $this->estruturaRepository = $estruturaRepository;
        $this->statusRepository = $statusRepository;
    }

    public function getBootstrapData(): array
    {
        return [
            'segmentos' => $this->estruturaRepository->findAllSegmentos(),
            'diretorias' => $this->estruturaRepository->findAllDiretorias(),
            'regionais' => $this->estruturaRepository->findAllRegionais(),
            'agencias' => $this->estruturaRepository->findAllAgencias(),
            'ggestoes' => $this->estruturaRepository->findAllGGestoes(),
            'gerentes' => $this->estruturaRepository->findAllGerentes(),
            'statusIndicadores' => $this->statusRepository->findAllAsArray(),
        ];
    }
}
