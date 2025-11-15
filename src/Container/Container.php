<?php

declare(strict_types=1);

namespace Pobj\Api\Container;

use Doctrine\ORM\EntityManager;
use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Database\DoctrineManager;
use Pobj\Api\Repositories\CalendarioRepository;
use Pobj\Api\Repositories\CampanhasRepository;
use Pobj\Api\Repositories\DetalhesRepository;
use Pobj\Api\Repositories\EstruturaRepository;
use Pobj\Api\Repositories\HistoricoRepository;
use Pobj\Api\Repositories\LeadsRepository;
use Pobj\Api\Repositories\MetaRepository;
use Pobj\Api\Repositories\OmegaMesuRepository;
use Pobj\Api\Repositories\OmegaStatusRepository;
use Pobj\Api\Repositories\OmegaStructureRepository;
use Pobj\Api\Repositories\OmegaTicketsRepository;
use Pobj\Api\Repositories\OmegaUsersRepository;
use Pobj\Api\Repositories\ProdutoRepository;
use Pobj\Api\Repositories\RealizadoRepository;
use Pobj\Api\Repositories\StatusIndicadoresRepository;
use Pobj\Api\Repositories\VariavelRepository;
use Pobj\Api\Services\AgentService;
use Pobj\Api\Services\BootstrapService;
use Pobj\Api\Services\FiltrosService;
use Pobj\Api\Services\OmegaMesuService;
use Pobj\Api\Services\OmegaStatusService;
use Pobj\Api\Services\OmegaStructureService;
use Pobj\Api\Services\OmegaTicketsService;
use Pobj\Api\Services\OmegaUsersService;
use Pobj\Api\Services\ResumoService;
use Pobj\Api\Services\StatusIndicadoresService;
use RuntimeException;

class Container
{
    private static ?Container $instance = null;
    private array $bindings = [];
    private array $instances = [];

    private function __construct()
    {
        $this->registerDefaults();
    }

    public static function getInstance(): Container
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function registerDefaults(): void
    {
        $this->singleton(PDO::class, function () {
            return DatabaseConnection::getConnection();
        });

        $this->singleton(EntityManager::class, function () {
            return DoctrineManager::getEntityManager();
        });

        $this->singleton(EstruturaRepository::class, function (Container $container) {
            return new EstruturaRepository($container->get(EntityManager::class));
        });

        $this->singleton(StatusIndicadoresRepository::class, function (Container $container) {
            return new StatusIndicadoresRepository($container->get(EntityManager::class));
        });

        $this->singleton(RealizadoRepository::class, function (Container $container) {
            return new RealizadoRepository($container->get(EntityManager::class));
        });

        $this->singleton(MetaRepository::class, function (Container $container) {
            return new MetaRepository($container->get(EntityManager::class));
        });

        $this->singleton(VariavelRepository::class, function (Container $container) {
            return new VariavelRepository($container->get(EntityManager::class));
        });

        $this->singleton(ProdutoRepository::class, function (Container $container) {
            return new ProdutoRepository($container->get(EntityManager::class));
        });

        $this->singleton(CalendarioRepository::class, function (Container $container) {
            return new CalendarioRepository($container->get(EntityManager::class));
        });

        $this->singleton(CampanhasRepository::class, function (Container $container) {
            return new CampanhasRepository($container->get(EntityManager::class));
        });

        $this->singleton(DetalhesRepository::class, function (Container $container) {
            return new DetalhesRepository($container->get(EntityManager::class));
        });

        $this->singleton(HistoricoRepository::class, function (Container $container) {
            return new HistoricoRepository($container->get(EntityManager::class));
        });

        $this->singleton(LeadsRepository::class, function (Container $container) {
            return new LeadsRepository($container->get(EntityManager::class));
        });

        $this->singleton(BootstrapService::class, function (Container $container) {
            return new BootstrapService(
                $container->get(EstruturaRepository::class),
                $container->get(StatusIndicadoresRepository::class),
                $container->get(RealizadoRepository::class),
                $container->get(MetaRepository::class),
                $container->get(VariavelRepository::class),
                $container->get(OmegaMesuRepository::class),
                $container->get(ProdutoRepository::class),
                $container->get(CalendarioRepository::class),
                $container->get(CampanhasRepository::class),
                $container->get(DetalhesRepository::class),
                $container->get(HistoricoRepository::class),
                $container->get(LeadsRepository::class)
            );
        });

        $this->singleton(FiltrosService::class, function (Container $container) {
            return new FiltrosService(
                $container->get(EstruturaRepository::class),
                $container->get(StatusIndicadoresRepository::class)
            );
        });

        $this->singleton(ResumoService::class, function (Container $container) {
            return new ResumoService(
                $container->get(RealizadoRepository::class),
                $container->get(MetaRepository::class)
            );
        });

        $this->singleton(StatusIndicadoresService::class, function (Container $container) {
            return new StatusIndicadoresService(
                $container->get(StatusIndicadoresRepository::class)
            );
        });

        $this->singleton(AgentService::class, function () {
            return new AgentService();
        });

        $this->singleton(OmegaUsersRepository::class, function (Container $container) {
            return new OmegaUsersRepository($container->get(EntityManager::class));
        });

        $this->singleton(OmegaUsersService::class, function (Container $container) {
            return new OmegaUsersService($container->get(OmegaUsersRepository::class));
        });

        $this->singleton(OmegaStatusRepository::class, function (Container $container) {
            return new OmegaStatusRepository($container->get(EntityManager::class));
        });

        $this->singleton(OmegaStatusService::class, function (Container $container) {
            return new OmegaStatusService($container->get(OmegaStatusRepository::class));
        });

        $this->singleton(OmegaStructureRepository::class, function (Container $container) {
            return new OmegaStructureRepository($container->get(EntityManager::class));
        });

        $this->singleton(OmegaStructureService::class, function (Container $container) {
            return new OmegaStructureService($container->get(OmegaStructureRepository::class));
        });

        $this->singleton(OmegaTicketsRepository::class, function (Container $container) {
            return new OmegaTicketsRepository($container->get(EntityManager::class));
        });

        $this->singleton(OmegaTicketsService::class, function (Container $container) {
            return new OmegaTicketsService($container->get(OmegaTicketsRepository::class));
        });

        $this->singleton(OmegaMesuRepository::class, function (Container $container) {
            return new OmegaMesuRepository($container->get(EntityManager::class));
        });

        $this->singleton(OmegaMesuService::class, function (Container $container) {
            return new OmegaMesuService($container->get(OmegaMesuRepository::class));
        });
    }

    public function singleton(string $abstract, callable $concrete): void
    {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => true,
        ];
    }

    public function bind(string $abstract, callable $concrete): void
    {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => false,
        ];
    }

    public function get(string $abstract): object
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (!isset($this->bindings[$abstract])) {
            throw new RuntimeException("Binding não encontrado para: {$abstract}");
        }

        $binding = $this->bindings[$abstract];
        $instance = $binding['concrete']($this);

        if ($binding['shared']) {
            $this->instances[$abstract] = $instance;
        }

        return $instance;
    }

    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }
}

