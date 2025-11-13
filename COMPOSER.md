# Composer - Gerenciador de Dependências

Este projeto agora utiliza [Composer](https://getcomposer.org/) para gerenciar dependências e autoloading.

## Benefícios

✅ **Autoloader PSR-4 otimizado** - Carregamento automático de classes mais eficiente  
✅ **Gerenciamento de dependências** - Facilita adicionar bibliotecas externas  
✅ **Padrão da indústria** - Segue as melhores práticas do ecossistema PHP  
✅ **Fallback automático** - Funciona mesmo sem Composer instalado

## Instalação

### Primeira vez

```bash
composer install
```

Ou apenas para gerar o autoloader (sem dependências externas):

```bash
composer dump-autoload
```

### Atualizar autoloader

Se você adicionar novas classes, execute:

```bash
composer dump-autoload
```

## Como funciona

O `src/bootstrap.php` detecta automaticamente se o Composer está disponível:

1. **Com Composer**: Usa `vendor/autoload.php` (mais rápido e otimizado)
2. **Sem Composer**: Usa autoloader simples como fallback

## Adicionar dependências

Para adicionar uma biblioteca externa:

```bash
composer require nome-do-pacote/versao
```

Exemplo:
```bash
composer require monolog/monolog
composer require symfony/http-foundation
```

## Estrutura

- `composer.json` - Configuração do projeto e dependências
- `vendor/` - Dependências instaladas (não versionar)
- `.gitignore` - Já configurado para ignorar `vendor/`

## Notas

- O projeto funciona **sem** Composer instalado (usa fallback)
- O autoloader do Composer é otimizado e mais rápido
- Facilita adicionar bibliotecas no futuro (HTTP clients, validators, etc)

