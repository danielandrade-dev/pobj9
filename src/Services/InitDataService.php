<?php

declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\CalendarioRepository;
use Pobj\Api\Repositories\CampanhasRepository;
use Pobj\Api\Repositories\DetalhesRepository;
use Pobj\Api\Repositories\EstruturaRepository;
use Pobj\Api\Repositories\HistoricoRepository;
use Pobj\Api\Repositories\LeadsRepository;
use Pobj\Api\Repositories\MetaRepository;
use Pobj\Api\Repositories\OmegaMesuRepository;
use Pobj\Api\Repositories\ProdutoRepository;
use Pobj\Api\Repositories\RealizadoRepository;
use Pobj\Api\Repositories\StatusIndicadoresRepository;
use Pobj\Api\Repositories\VariavelRepository;

class InitDataService
{
    private EstruturaRepository $estruturaRepository;
    private StatusIndicadoresRepository $statusRepository;
    private RealizadoRepository $realizadoRepository;
    private MetaRepository $metaRepository;
    private VariavelRepository $variavelRepository;
    private OmegaMesuRepository $mesuRepository;
    private ProdutoRepository $produtoRepository;
    private CalendarioRepository $calendarioRepository;
    private CampanhasRepository $campanhasRepository;
    private DetalhesRepository $detalhesRepository;
    private HistoricoRepository $historicoRepository;
    private LeadsRepository $leadsRepository;

    public function __construct(
        EstruturaRepository $estruturaRepository,
        StatusIndicadoresRepository $statusRepository,
        RealizadoRepository $realizadoRepository,
        MetaRepository $metaRepository,
        VariavelRepository $variavelRepository,
        OmegaMesuRepository $mesuRepository,
        ProdutoRepository $produtoRepository,
        CalendarioRepository $calendarioRepository,
        CampanhasRepository $campanhasRepository,
        DetalhesRepository $detalhesRepository,
        HistoricoRepository $historicoRepository,
        LeadsRepository $leadsRepository
    ) {
        $this->estruturaRepository = $estruturaRepository;
        $this->statusRepository = $statusRepository;
        $this->realizadoRepository = $realizadoRepository;
        $this->metaRepository = $metaRepository;
        $this->variavelRepository = $variavelRepository;
        $this->mesuRepository = $mesuRepository;
        $this->produtoRepository = $produtoRepository;
        $this->calendarioRepository = $calendarioRepository;
        $this->campanhasRepository = $campanhasRepository;
        $this->detalhesRepository = $detalhesRepository;
        $this->historicoRepository = $historicoRepository;
        $this->leadsRepository = $leadsRepository;
    }

    public function getInitData(): array
    {
        $segmentos = $this->estruturaRepository->findAllSegmentos();
        $diretorias = $this->estruturaRepository->findAllDiretorias();
        $regionais = $this->estruturaRepository->findAllRegionais();
        $agencias = $this->estruturaRepository->findAllAgencias();
        $ggestoes = $this->estruturaRepository->findAllGGestoes();
        $gerentes = $this->estruturaRepository->findAllGerentes();
        $status = $this->statusRepository->findAllAsArray();
        
        return [
            'dimSegmentos' => $segmentos,
            'dimDiretorias' => $diretorias,
            'dimRegionais' => $regionais,
            'dimAgencias' => $agencias,
            'dimGerentesGestao' => $ggestoes,
            'dimGerentes' => $gerentes,
            
            'segmentosDim' => $segmentos,
            'diretoriasDim' => $diretorias,
            'regionaisDim' => $regionais,
            'agenciasDim' => $agencias,
            'gerentesGestaoDim' => $ggestoes,
            'gerentesDim' => $gerentes,
            
            'segmentos' => $segmentos,
            'diretorias' => $diretorias,
            'regionais' => $regionais,
            'agencias' => $agencias,
            'ggestoes' => $ggestoes,
            'gerentes' => $gerentes,
            
            'statusIndicadores' => $status,
            'status' => $status,
            
            'realizados' => $this->realizadoRepository->findAllAsArray(),
            'metas' => $this->metaRepository->findAllAsArray(),
            'variavel' => $this->variavelRepository->findAllAsArray(),
            
            'mesu' => $this->mesuRepository->findAll(),
            'produtos' => $this->produtoRepository->findAllAsArray(),
            'calendario' => $this->calendarioRepository->findAllAsArray(),
            
            'campanhas' => $this->campanhasRepository->findAllAsArray(),
            'detalhes' => $this->detalhesRepository->findAllAsArray(),
            'historico' => $this->historicoRepository->findAllAsArray(),
            'leads' => $this->leadsRepository->findAllAsArray(),
        ];
    }
}

