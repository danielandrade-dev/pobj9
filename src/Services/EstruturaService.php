<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\EstruturaRepository;

class EstruturaService
{
    private EstruturaRepository $repository;

    public function __construct(EstruturaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllEstrutura(): array
    {
        return [
            'segmentos'       => $this->repository->findAllSegmentos(),
            'diretorias'      => $this->repository->findAllDiretorias(),
            'regionais'       => $this->repository->findAllRegionais(),
            'agencias'        => $this->repository->findAllAgencias(),
            'gerentes_gestao' => $this->repository->findAllGGestoes(),
            'gerentes'        => $this->repository->findAllGerentes(),
        ];
    }
}

