# Resources

Este diretório contém recursos do front-end que podem ser processados ou compilados antes de serem servidos.

## Estrutura

```
resources/
├── views/          # Templates/views HTML
│   ├── index.html  # Página principal
│   ├── 404.html    # Página de erro 404
│   ├── omega.html  # View do módulo Omega
│   └── leads.html  # View do módulo Leads
├── assets/         # Assets não compilados (se necessário no futuro)
└── README.md       # Este arquivo
```

## Views

As views HTML estão localizadas em `resources/views/` e são processadas pela classe `Pobj\Api\Http\View`. 

A classe View:
- Processa automaticamente os caminhos de assets públicos
- Suporta variáveis simples usando `{{variavel}}`
- Aplica substituições de caminhos para garantir que os assets sejam servidos corretamente

### Exemplo de uso

```php
$view = new View($projectRoot);
$content = $view->render('index', ['title' => 'Meu Título']);
```

## Nota

Os arquivos estáticos (CSS, JS, imagens) continuam em `public/`. Este diretório `resources/` contém apenas templates que precisam ser processados antes de serem servidos.

