# Doctrine Migrations

Este diretório contém as migrations do Doctrine para gerenciar o schema do banco de dados.

## Como usar

### Gerar uma nova migration

Para gerar uma nova migration baseada nas mudanças nas entidades:

```bash
php bin/migrations migrations:generate
```

Ou para gerar uma migration vazia:

```bash
php bin/migrations migrations:generate --empty
```

### Executar migrations

Para executar todas as migrations pendentes:

```bash
php bin/migrations migrations:migrate
```

Para executar até uma versão específica:

```bash
php bin/migrations migrations:migrate --version=20240101000000
```

### Ver status das migrations

Para ver quais migrations foram executadas e quais estão pendentes:

```bash
php bin/migrations migrations:status
```

### Listar migrations

Para listar todas as migrations disponíveis:

```bash
php bin/migrations migrations:list
```

### Reverter migrations

Para reverter a última migration executada:

```bash
php bin/migrations migrations:migrate --down
```

### Ver SQL sem executar

Para ver o SQL que será executado sem aplicar as mudanças:

```bash
php bin/migrations migrations:migrate --dry-run
```

## Estrutura de uma Migration

Uma migration típica tem esta estrutura:

```php
<?php

declare(strict_types=1);

namespace Pobj\Api\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240101000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Descrição da migration';
    }

    public function up(Schema $schema): void
    {
        // Código para aplicar a migration
        $this->addSql('CREATE TABLE exemplo (id INT AUTO_INCREMENT PRIMARY KEY)');
    }

    public function down(Schema $schema): void
    {
        // Código para reverter a migration
        $this->addSql('DROP TABLE exemplo');
    }
}
```


