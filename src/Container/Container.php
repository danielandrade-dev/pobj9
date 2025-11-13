<?php

declare(strict_types=1);

namespace Pobj\Api\Container;

use PDO;
use Pobj\Api\Database\DatabaseConnection;
use Pobj\Api\Repositories\EstruturaRepository;
use Pobj\Api\Repositories\MetaRepository;
use Pobj\Api\Repositories\RealizadoRepository;
use Pobj\Api\Repositories\StatusIndicadoresRepository;
use Pobj\Api\Services\AgentService;
use Pobj\Api\Services\BootstrapService;
use Pobj\Api\Services\FiltrosService;
use Pobj\Api\Services\ResumoService;
use Pobj\Api\Services\StatusIndicadoresService;

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

        $this->singleton(EstruturaRepository::class, function (Container $container) {
            return new EstruturaRepository($container->get(PDO::class));
        });

        $this->singleton(StatusIndicadoresRepository::class, function (Container $container) {
            return new StatusIndicadoresRepository($container->get(PDO::class));
        });

        $this->singleton(RealizadoRepository::class, function (Container $container) {
            return new RealizadoRepository($container->get(PDO::class));
        });

        $this->singleton(MetaRepository::class, function (Container $container) {
            return new MetaRepository($container->get(PDO::class));
        });

        $this->singleton(BootstrapService::class, function (Container $container) {
            return new BootstrapService(
                $container->get(EstruturaRepository::class),
                $container->get(StatusIndicadoresRepository::class)
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
            throw new \RuntimeException("Binding não encontrado para: {$abstract}");
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

