# API POBJ - Estrutura PSR-12

API PHP organizada seguindo padrões PSR-12 e PSR-4.

## Estrutura de Diretórios

```
src/
├── index.php                    # Ponto de entrada principal
├── bootstrap.php                # Autoloader e inicialização
├── Database/
│   └── DatabaseConnection.php    # Gerenciamento de conexão PDO
├── Http/
│   └── Handlers/                 # Handlers HTTP
│       ├── AgentHandler.php
│       ├── BootstrapHandler.php
│       ├── FiltrosHandler.php
│       ├── ResumoHandler.php
│       └── StatusIndicadoresHandler.php
├── Response/
│   └── ResponseHelper.php         # Helpers de resposta JSON
├── Ai/
│   └── KnowledgeHelper.php        # Helper para funcionalidades de IA/RAG
└── README.md                    # Esta documentação
```

## Namespaces (PSR-4)

- `Pobj\Api\Database` - Classes relacionadas ao banco de dados
- `Pobj\Api\Http\Handlers` - Handlers HTTP para endpoints
- `Pobj\Api\Response` - Classes de resposta HTTP
- `Pobj\Api\Ai` - Classes relacionadas a IA/RAG
- `Pobj\Api\Helpers` - Classes helper utilitárias

## Padrões Seguidos

### PSR-12
- ✅ Declaração `declare(strict_types=1)` em todos os arquivos
- ✅ Classes em PascalCase
- ✅ Métodos em camelCase
- ✅ Propriedades privadas com type hints
- ✅ DocBlocks completos
- ✅ Indentação consistente (4 espaços)

### PSR-4
- ✅ Autoloader seguindo PSR-4
- ✅ Namespaces correspondem à estrutura de diretórios
- ✅ Um arquivo por classe
- ✅ Nome do arquivo igual ao nome da classe

## Classes Principais

### `DatabaseConnection`
Gerencia conexões PDO e execução de queries:
- `getConnection(): PDO` - Retorna conexão configurada
- `query(PDO $pdo, string $sql, array $bind = []): array` - Executa query

### `ResponseHelper`
Utilitários para respostas HTTP JSON:
- `json($data): void` - Envia resposta JSON
- `error(string $message, int $status = 400): void` - Envia erro JSON

### Handlers HTTP
Cada handler encapsula a lógica de um grupo de endpoints:
- **AgentHandler** - Agente de IA (OpenAI)
- **BootstrapHandler** - Dados iniciais do frontend
- **FiltrosHandler** - Filtros (segmentos, diretorias, regionais, etc)
- **ResumoHandler** - Resumo com filtros
- **StatusIndicadoresHandler** - Status de indicadores

## Endpoints Disponíveis

- `?endpoint=health` - Health check
- `?endpoint=agent` (POST) - Agente de IA
- `?endpoint=filtros&nivel={nivel}` - Filtros por nível
- `?endpoint=bootstrap` - Carrega todos os dados iniciais
- `?endpoint=status_indicadores` - Lista de status
- `?endpoint=resumo&data_ini={data}&data_fim={data}&...` - Resumo com filtros

## Como Adicionar um Novo Endpoint

1. Crie um novo handler em `Http/Handlers/`:
```php
<?php
declare(strict_types=1);

namespace Pobj\Api\Http\Handlers;

use PDO;
use Pobj\Api\Response\ResponseHelper;

class NovoHandler
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function handle(): void
    {
        ResponseHelper::json(['data' => 'exemplo']);
    }
}
```

2. Adicione o caso no switch do `index.php`:
```php
case 'novo':
    $handler = new NovoHandler($pdo);
    $handler->handle();
    break;
```

## Compatibilidade

A estrutura mantém 100% de compatibilidade com os endpoints existentes. Nenhuma mudança é necessária no frontend.
