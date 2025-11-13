<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Enums\FiltroNivel;
use Pobj\Api\Repositories\EstruturaRepository;
use Pobj\Api\Repositories\StatusIndicadoresRepository;

class FiltrosService
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

    public function getFiltroByNivel(FiltroNivel $nivel): array
    {
        return match ($nivel) {
            FiltroNivel::SEGMENTOS => $this->estruturaRepository->findSegmentosForFilter(),
            FiltroNivel::DIRETORIAS => $this->estruturaRepository->findDiretoriasForFilter(),
            FiltroNivel::REGIONAIS => $this->estruturaRepository->findRegionaisForFilter(),
            FiltroNivel::AGENCIAS => $this->estruturaRepository->findAgenciasForFilter(),
            FiltroNivel::GGESTOES => $this->estruturaRepository->findGGestoesForFilter(),
            FiltroNivel::GERENTES => $this->estruturaRepository->findGerentesForFilter(),
            FiltroNivel::STATUS_INDICADORES => $this->statusRepository->findAllForFilter(),
        };
    }
}
