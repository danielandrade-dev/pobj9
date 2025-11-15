# Estrutura de Views

Esta pasta contém todas as views (templates HTML) do projeto, organizadas de forma hierárquica e sem duplicação de código.

## Estrutura de Pastas

```
resources/views/
├── index.html          # Página principal
├── omega.html          # Página standalone do Omega
├── 404.html            # Página de erro 404
│
├── layouts/            # Componentes de layout base
│   ├── meta.html       # Meta tags
│   ├── header-topbar.html
│   ├── footer.html
│   └── scripts.html
│
├── assets/             # Assets (estilos, fonts, favicons)
│   ├── styles-main.html
│   ├── styles-omega.html
│   ├── styles-404.html
│   ├── fonts.html
│   ├── favicon.html
│   └── favicon-omega.html
│
└── components/          # Componentes reutilizáveis
    ├── modals/         # Modais
    │   ├── omega-modal.html
    │   └── leads-modal.html
    │
    ├── filters/        # Componentes de filtros
    │   ├── filters-basic.html
    │   ├── filters-advanced.html
    │   ├── filters-card-header.html
    │   ├── filters-backdrop.html
    │   └── resumo-mode-toggle.html
    │
    └── sections/       # Seções da página
        ├── tabs-navigation.html
        ├── detail-designer.html
        └── mobile-carousel.html
```

## Como Usar

### Includes com caminho explícito (recomendado)
```html
@include('layouts/meta')
@include('components/modals/omega-modal')
@include('assets/styles-main')
```

### Includes sem caminho (busca automática)
O ViewRenderer busca automaticamente em todas as pastas na seguinte ordem:
1. `layouts/`
2. `components/modals/`
3. `components/filters/`
4. `components/sections/`
5. `assets/`
6. `components/` (fallback)

```html
@include('meta')           # Encontra em layouts/
@include('omega-modal')    # Encontra em components/modals/
@include('styles-main')    # Encontra em assets/
```

## Princípios de Organização

1. **Sem duplicação**: Cada componente existe apenas uma vez
2. **Separação por função**: Componentes agrupados por tipo (layout, modal, filtro, etc)
3. **Caminhos explícitos**: Prefira usar caminhos completos para clareza
4. **Reutilização**: Componentes podem ser incluídos em múltiplas páginas
