# API POBJ - Arquitetura Moderna

API PHP organizada seguindo padrões PSR-12, PSR-4 e padrões de projeto modernos.

## Estrutura de Diretórios

```
src/
├── index.php                    # Ponto de entrada principal
├── bootstrap.php                # Autoloader e inicialização
├── Container/
│   └── Container.php            # Dependency Injection Container
├── Repositories/                # Repository Pattern
│   ├── EstruturaRepository.php
│   ├── MetaRepository.php
│   ├── RealizadoRepository.php
│   ├── StatusIndicadoresRepository.php
│   └── RepositoryInterface.php
├── Services/                    # Service Layer
│   ├── AgentService.php
│   ├── BootstrapService.php
│   ├── FiltrosService.php
│   ├── ResumoService.php
│   └── StatusIndicadoresService.php
├── Http/
│   ├── Controllers/             # Controllers HTTP
│   │   ├── AgentController.php
│   │   ├── BootstrapController.php
│   │   ├── FiltrosController.php
│   │   ├── HealthController.php
│   │   ├── ResumoController.php
│   │   └── StatusIndicadoresController.php
│   ├── Router.php
│   └── routes.php
├── Database/
│   ├── DatabaseConnection.php
│   └── DoctrineManager.php
├── Response/
│   └── ResponseHelper.php
├── Enums/                      # Enums para valores fixos
│   ├── FiltroNivel.php
│   ├── HttpMethod.php
│   ├── HttpStatusCode.php
│   └── StatusIndicador.php
├── Ai/
│   └── KnowledgeHelper.php
└── Helpers/
    ├── EnvHelper.php
    ├── ErrorHandler.php
    └── Logger.php
```

## Arquitetura

### Camadas

1. **Controllers** - Validação de entrada e delegação para Services
2. **Services** - Lógica de negócio
3. **Repositories** - Acesso a dados
4. **Container** - Gerenciamento de dependências

### Fluxo de Requisição

```
Request → Router → Controller → Service → Repository → Database
                                    ↓
                              ResponseHelper → Response
```

## Padrões Implementados

- **Repository Pattern** - Abstração de acesso a dados
- **Service Layer** - Separação de lógica de negócio
- **Dependency Injection** - Container gerencia dependências
- **MVC** - Model-View-Controller (Controllers como View)
- **Enums** - Valores fixos tipados (evita hardcoded strings)

## Namespaces (PSR-4)

- `Pobj\Api\Container` - Dependency Injection Container
- `Pobj\Api\Repositories` - Repositories para acesso a dados
- `Pobj\Api\Services` - Services com lógica de negócio
- `Pobj\Api\Http\Controllers` - Controllers HTTP
- `Pobj\Api\Database` - Classes relacionadas ao banco de dados
- `Pobj\Api\Response` - Classes de resposta HTTP
- `Pobj\Api\Enums` - Enums para valores fixos
- `Pobj\Api\Ai` - Classes relacionadas a IA/RAG
- `Pobj\Api\Helpers` - Classes helper utilitárias

## Endpoints Disponíveis

- `?endpoint=health` - Health check
- `?endpoint=agent` (POST) - Agente de IA
- `?endpoint=filtros&nivel={nivel}` - Filtros por nível
- `?endpoint=bootstrap` - Carrega todos os dados iniciais
- `?endpoint=status_indicadores` - Lista de status
- `?endpoint=resumo&data_ini={data}&data_fim={data}&...` - Resumo com filtros

## Como Adicionar um Novo Endpoint

1. Crie um Repository (se necessário):
```php
<?php
declare(strict_types=1);

namespace Pobj\Api\Repositories;

use PDO;
use Pobj\Api\Database\DatabaseConnection;

class NovoRepository implements RepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findSomething(): array
    {
        return DatabaseConnection::query($this->pdo, 'SELECT ...');
    }
}
```

2. Crie um Service:
```php
<?php
declare(strict_types=1);

namespace Pobj\Api\Services;

use Pobj\Api\Repositories\NovoRepository;

class NovoService
{
    private NovoRepository $repository;

    public function __construct(NovoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getData(): array
    {
        return $this->repository->findSomething();
    }
}
```

3. Crie um Controller:
```php
<?php
declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\NovoService;

class NovoController
{
    public function handle(array $params, $payload = null): void
    {
        $container = Container::getInstance();
        $service = $container->get(NovoService::class);
        $result = $service->getData();
        ResponseHelper::json($result);
    }
}
```

4. Registre no Container (`Container.php`):
```php
$this->singleton(NovoRepository::class, function (Container $container) {
    return new NovoRepository($container->get(PDO::class));
});

$this->singleton(NovoService::class, function (Container $container) {
    return new NovoService($container->get(NovoRepository::class));
});
```

5. Adicione a rota (`routes.php`):
```php
use Pobj\Api\Enums\HttpMethod;

$router->add('novo', NovoController::class, 'handle', [HttpMethod::GET->value]);
```
