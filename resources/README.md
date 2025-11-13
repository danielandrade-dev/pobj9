# Resources

Este diretório contém recursos do front-end que podem ser processados ou compilados antes de serem servidos.

## Estrutura

```
resources/
├── views/          # Templates/views (se necessário no futuro)
├── assets/         # Assets não compilados (se necessário no futuro)
└── README.md        # Este arquivo
```

## Nota

Atualmente, todos os arquivos estáticos estão em `public/`. Este diretório `resources/` foi criado para seguir a convenção de frameworks PHP modernos e pode ser usado no futuro para:

- Templates/views que precisam ser processados
- Assets que precisam ser compilados (SASS, TypeScript, etc.)
- Outros recursos que não devem ser servidos diretamente

