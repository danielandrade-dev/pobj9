# Colunas Esperadas pelo BootstrapService

Este documento lista todas as colunas que cada tipo de dado precisa ter para ser processado corretamente pelo JavaScript.

## Estrutura JSON

```json
{
  "realizados": {
    "nome": "FACT_REALIZADOS",
    "descricao": "Dados de realizados dos indicadores",
    "obrigatorias": [
      "Registro ID",
      "id_indicador"
    ],
    "colunas": {
      "identificacao": {
        "registroId": ["Registro ID", "ID", "registro", "registro_id"],
        "produtoId": ["id_indicador", "Produto ID", "Produto", "Id Produto"]
      },
      "estrutura": {
        "segmento": ["Segmento", "segmento"],
        "segmentoId": ["Segmento ID", "Id Segmento", "segmento_id"],
        "diretoriaId": ["Diretoria ID", "Diretoria", "Id Diretoria", "Diretoria Codigo"],
        "diretoriaNome": ["Diretoria Nome", "Diretoria Regional"],
        "gerenciaId": ["Gerencia ID", "Gerencia Regional", "Id Gerencia Regional"],
        "gerenciaNome": ["Gerencia Nome", "Gerencia Regional", "Regional Nome"],
        "regionalNome": ["Regional Nome", "Regional"],
        "agenciaId": ["Agencia ID", "Id Agencia", "Agência ID", "Agencia"],
        "agenciaNome": ["Agencia Nome", "Agência Nome", "Agencia"],
        "agenciaCodigo": ["Agencia Codigo", "Código Agência", "Codigo Agencia"],
        "gerenteGestaoId": ["Gerente Gestao ID", "Gerente Gestao", "Id Gerente de Gestao", "Id Gerente de Gestão", "gerenteGestaoId", "gerente_gestao_id"],
        "gerenteGestaoNome": ["Gerente Gestao Nome", "Gerente de Gestao Nome", "Gerente de Gestão Nome", "Gerente de Gestao", "Gerente de Gestão", "Gerente Gestao", "gerenteGestaoNome", "gerente_gestao_nome"],
        "gerenteId": ["Gerente ID", "Gerente"],
        "gerenteNome": ["Gerente Nome", "Gerente"]
      },
      "produto": {
        "familiaId": ["Familia ID", "Familia", "Família ID"],
        "familiaNome": ["Familia Nome", "Família", "Familia"],
        "produtoNome": ["ds_indicador", "Produto Nome", "Produto"],
        "subproduto": ["Subproduto", "Sub produto", "Sub-Produto"],
        "familiaCodigo": ["Familia Codigo", "Familia Código", "FamiliaCod"],
        "indicadorCodigo": ["Indicador Codigo", "Indicador Código", "IndicadorCod"],
        "subCodigo": ["Subindicador Codigo", "Subindicador Código", "SubindicadorCod"]
      },
      "vendas": {
        "carteira": ["Carteira"],
        "canalVenda": ["Canal Venda", "Canal"],
        "tipoVenda": ["Tipo Venda", "Tipo"],
        "modalidadePagamento": ["Modalidade Pagamento", "Modalidade"]
      },
      "datas": {
        "data": ["Data", "Data Movimento", "Data Movimentacao", "Data Movimentação"],
        "competencia": ["Competencia", "Competência"]
      },
      "valores": {
        "realizadoMensal": ["Realizado Mensal", "Realizado"],
        "realizadoAcumulado": ["Realizado Acumulado", "Realizado Acum"],
        "quantidade": ["Quantidade", "Qtd"],
        "variavelReal": ["Variavel Real", "Variável Real"]
      }
    }
  },
  "metas": {
    "nome": "FACT_METAS",
    "descricao": "Dados de metas dos indicadores",
    "obrigatorias": [
      "Registro ID"
    ],
    "colunas": {
      "identificacao": {
        "registroId": ["Registro ID", "ID", "registro"]
      },
      "estrutura": {
        "segmento": ["Segmento", "Segmento ID", "Id Segmento"],
        "diretoriaId": ["Diretoria ID", "Diretoria", "Id Diretoria"],
        "diretoriaNome": ["Diretoria Nome", "Diretoria Regional"],
        "gerenciaId": ["Gerencia ID", "Gerencia Regional", "Id Gerencia Regional"],
        "gerenciaNome": ["Gerencia Nome", "Gerencia Regional", "Regional Nome"],
        "regionalNome": ["Regional Nome", "Regional"],
        "agenciaId": ["Agencia ID", "Agência ID", "Id Agencia"],
        "agenciaCodigo": ["Agencia Codigo", "Agência Codigo", "Codigo Agencia"],
        "agenciaNome": ["Agencia Nome", "Agência Nome", "Agencia"],
        "gerenteGestaoId": ["Gerente Gestao ID", "Gerente Gestao", "Id Gerente de Gestao", "Id Gerente de Gestão", "gerenteGestaoId", "gerente_gestao_id"],
        "gerenteGestaoNome": ["Gerente Gestao Nome", "Gerente de Gestao Nome", "Gerente de Gestão Nome", "Gerente de Gestao", "Gerente de Gestão", "Gerente Gestao", "gerenteGestaoNome", "gerente_gestao_nome"],
        "gerenteId": ["Gerente ID", "Gerente"],
        "gerenteNome": ["Gerente Nome", "Gerente"]
      },
      "produto": {
        "familiaId": ["Familia ID", "Familia", "Família ID"],
        "familiaNome": ["Familia Nome", "Família Nome", "Familia"],
        "produtoId": ["id_indicador", "Produto ID", "Produto", "Id Produto"],
        "produtoNome": ["ds_indicador", "Produto Nome", "Produto"],
        "subproduto": ["Subproduto", "Sub produto", "Sub-Produto"],
        "familiaCodigo": ["Familia Codigo", "Familia Código", "FamiliaCod"],
        "indicadorCodigo": ["Indicador Codigo", "Indicador Código", "IndicadorCod"],
        "subCodigo": ["Subindicador Codigo", "Subindicador Código", "SubindicadorCod"]
      },
      "vendas": {
        "carteira": ["Carteira"],
        "canalVenda": ["Canal Venda", "Canal"],
        "tipoVenda": ["Tipo Venda", "Tipo"],
        "modalidadePagamento": ["Modalidade Pagamento", "Modalidade"]
      },
      "datas": {
        "data": ["Data", "Data Competencia", "Data da Meta"],
        "competencia": ["Competencia", "Competência"]
      },
      "valores": {
        "metaMensal": ["Meta Mensal", "Meta"],
        "metaAcumulada": ["Meta Acumulada", "Meta Acum"],
        "variavelMeta": ["Variavel Meta", "Variável Meta"],
        "peso": ["Peso"]
      }
    }
  },
  "variavel": {
    "nome": "FACT_VARIAVEL",
    "descricao": "Dados de variável estimada (pontos)",
    "obrigatorias": [
      "Registro ID"
    ],
    "colunas": {
      "identificacao": {
        "registroId": ["Registro ID", "ID", "registro"]
      },
      "produto": {
        "produtoId": ["id_indicador", "Produto ID", "Produto", "Id Produto"],
        "produtoNome": ["ds_indicador", "Produto Nome", "Produto"],
        "familiaId": ["Familia ID", "Familia", "Família ID"],
        "familiaNome": ["Familia Nome", "Família Nome", "Familia"],
        "familiaCodigo": ["Familia Codigo", "Familia Código", "FamiliaCod"],
        "indicadorCodigo": ["Indicador Codigo", "Indicador Código", "IndicadorCod"],
        "subCodigo": ["Subindicador Codigo", "Subindicador Código", "SubindicadorCod"]
      },
      "datas": {
        "data": ["Data"],
        "competencia": ["Competencia", "Competência"]
      },
      "valores": {
        "variavelMeta": ["Variavel Meta", "Variável Meta"],
        "variavelReal": ["Variavel Real", "Variável Real"]
      }
    }
  },
  "mesu": {
    "nome": "MESU",
    "descricao": "Estrutura organizacional (hierarquia)",
    "obrigatorias": [],
    "colunas": {
      "segmento": {
        "segmentoNome": ["Segmento", "segmento"],
        "segmentoId": ["Id Segmento", "ID Segmento", "id segmento", "Id segmento", "segmento_id", "segmentoId", "segmentoID"],
        "segmentoLabel": ["Segmento Label", "segmento_label", "segmentoLabel"]
      },
      "diretoria": {
        "diretoriaNome": ["Diretoria", "Diretoria Regional", "diretoria", "Diretoria regional", "diretoria_regional", "Diretoria_regional"],
        "diretoriaId": ["Id Diretoria", "ID Diretoria", "Diretoria ID", "Id Diretoria Regional", "id diretoria", "diretoria_id", "diretoriaId"],
        "diretoriaLabel": ["Diretoria Label", "diretoria_label", "diretoriaLabel", "Diretoria Rotulo", "diretoria_rotulo"]
      },
      "regional": {
        "regionalNome": ["Regional", "Gerencia Regional", "Gerência Regional", "Gerencia regional", "Regional Nome", "gerencia_regional", "Gerencia_regional"],
        "regionalId": ["Id Regional", "ID Regional", "Id Gerencia Regional", "Id Gerência Regional", "Gerencia ID", "gerencia_regional_id", "regional_id", "regionalId"],
        "regionalLabel": ["Gerencia Regional Label", "Gerência Regional Label", "regional_label", "gerencia_regional_label", "gerenciaRegionalLabel"]
      },
      "agencia": {
        "agenciaNome": ["Agencia", "Agência", "Agencia Nome", "Agência Nome", "agencia", "agencia_nome"],
        "agenciaId": ["Id Agencia", "ID Agencia", "Id Agência", "Agencia ID", "Agência ID", "agencia_id", "agenciaId"],
        "agenciaCodigo": ["Agencia Codigo", "Agência Codigo", "Codigo Agencia", "Código Agência", "agencia_codigo", "codigo_agencia"],
        "agenciaLabel": ["Agencia Label", "Agência Label", "agencia_label", "agenciaLabel"]
      },
      "gerenteGestao": {
        "gerenteGestaoNome": ["Gerente Gestao Nome", "Gerente de Gestao Nome", "Gerente de Gestão Nome", "Gerente de Gestao", "Gerente de Gestão", "Gerente Gestao", "gerente_gestao_nome", "gerente_gestao"],
        "gerenteGestaoId": ["Id Gerente de Gestao", "ID Gerente de Gestao", "Id Gerente de Gestão", "Gerente de Gestao Id", "gerenteGestaoId", "gerente_gestao_id"],
        "gerenteGestaoLabel": ["Gerente Gestao Label", "gerente_gestao_label", "gerenteGestaoLabel"]
      },
      "gerente": {
        "gerenteNome": ["Gerente", "Gerente Nome", "Nome Gerente", "Gerente Geral", "Gerente geral", "gerente"],
        "gerenteId": ["Id Gerente", "ID Gerente", "Gerente Id", "gerente_id", "gerenteId"],
        "gerenteLabel": ["Gerente Label", "gerente_label", "gerenteLabel"]
      }
    }
  },
  "produtos": {
    "nome": "DIM_PRODUTOS",
    "descricao": "Dimensão de produtos/indicadores",
    "obrigatorias": [],
    "colunas": {
      "familia": {
        "familiaCodigo": ["idFamilia", "IdFamilia", "ID Familia", "Id Familia", "Familia ID"],
        "familiaSlug": ["FamiliaSlug", "SlugFamilia", "Familia Slug", "Familia Chave", "Familia Codigo Alternativo"],
        "familiaNome": ["Familia", "Família", "Nome Familia", "Nome Família"]
      },
      "indicador": {
        "indicadorCodigo": ["IdIndicador", "ID Indicador", "Indicador ID", "Indicador Codigo", "Indicador Código"],
        "indicadorSlug": ["IndicadorSlug", "SlugIndicador", "Indicador Slug", "Indicador Chave", "CardId"],
        "indicadorNome": ["Indicador", "Nome Indicador", "Nome indicador"],
        "indicadorAliases": ["Indicador Aliases", "Indicador Alias", "Aliases Indicador", "IndicadorAliases"]
      },
      "subindicador": {
        "subCodigo": ["idSubindicador", "IdSubindicador", "ID Subindicador", "Subindicador ID", "Subindicador Codigo", "Subindicador Código"],
        "subSlug": ["SubindicadorSlug", "SlugSubindicador", "Subindicador Slug", "Subindicador Chave", "SubprodutoSlug"],
        "subNome": ["Subindicador", "Nome Subindicador", "Sub Indicador"],
        "subAliases": ["Subindicador Aliases", "Subindicador Alias", "Aliases Subindicador", "SubindicadorAliases"]
      }
    }
  },
  "calendario": {
    "nome": "DIM_CALENDARIO",
    "descricao": "Calendário corporativo (competências)",
    "obrigatorias": [
      "Data"
    ],
    "colunas": {
      "data": {
        "data": ["Data"],
        "competencia": ["Competencia", "Competência"]
      },
      "temporal": {
        "ano": ["Ano"],
        "mes": ["Mes", "Mês"],
        "mesNome": ["Mes Nome", "Mês Nome"],
        "dia": ["Dia"],
        "diaSemana": ["Dia da Semana"],
        "semana": ["Semana"],
        "trimestre": ["Trimestre"],
        "semestre": ["Semestre"],
        "ehDiaUtil": ["Eh Dia Util", "É Dia Útil", "Dia Util"]
      }
    }
  },
  "campanhas": {
    "nome": "FACT_CAMPANHAS",
    "descricao": "Dados de campanhas e sprints",
    "obrigatorias": [
      "Campanha ID",
      "id_indicador"
    ],
    "colunas": {
      "identificacao": {
        "campanhaId": ["Campanha ID", "ID"],
        "sprintId": ["Sprint ID", "Sprint"]
      },
      "estrutura": {
        "diretoriaId": ["Diretoria", "Diretoria ID", "Id Diretoria"],
        "diretoriaNome": ["Diretoria Nome", "Diretoria Regional"],
        "gerenciaId": ["Gerencia Regional", "Gerencia ID", "Id Gerencia"],
        "regionalNome": ["Regional Nome", "Regional"],
        "agenciaCodigo": ["Agencia Codigo", "Agencia ID", "Código Agência", "Agência Codigo"],
        "agenciaNome": ["Agencia Nome", "Agência Nome", "Agencia"],
        "gerenteGestaoId": ["Gerente Gestao", "Gerente Gestao ID", "Gerente de Gestao", "Gerente de Gestão", "gerenteGestaoId", "gerente_gestao_id"],
        "gerenteGestaoNome": ["Gerente Gestao Nome", "Gerente de Gestao Nome", "Gerente de Gestão Nome", "Gerente Gestao", "Gerente de Gestao", "Gerente de Gestão", "gerenteGestaoNome", "gerente_gestao_nome"],
        "gerenteId": ["Gerente", "Gerente ID"],
        "gerenteNome": ["Gerente Nome"],
        "segmento": ["Segmento"]
      },
      "produto": {
        "familiaId": ["Familia ID", "Família ID", "Familia"],
        "familiaNome": ["Familia Nome", "Família Nome"],
        "produtoId": ["id_indicador", "Produto ID", "Produto"],
        "produtoNome": ["ds_indicador", "Produto Nome", "Produto"],
        "subproduto": ["Subproduto", "Sub produto"],
        "familiaCodigo": ["Familia Codigo", "Familia Código", "FamiliaCod"],
        "indicadorCodigo": ["Indicador Codigo", "Indicador Código", "IndicadorCod"],
        "subCodigo": ["Subindicador Codigo", "Subindicador Código", "SubindicadorCod"],
        "carteira": ["Carteira"]
      },
      "valores": {
        "linhas": ["Linhas"],
        "cash": ["Cash"],
        "conquista": ["Conquista"],
        "atividade": ["Atividade", "Ativo", "Status"]
      },
      "datas": {
        "data": ["Data"],
        "competencia": ["Competencia", "Competência"]
      }
    }
  },
  "detalhes": {
    "nome": "FACT_DETALHES",
    "descricao": "Detalhes de contratos",
    "obrigatorias": [
      "Contrato ID",
      "Registro ID"
    ],
    "colunas": {
      "identificacao": {
        "contratoId": ["Contrato ID", "contrato_id", "Contrato", "Id Contrato", "ID Contrato"],
        "registroId": ["Registro ID", "registro_id", "Registro", "Id Registro", "ID Registro"]
      },
      "estrutura": {
        "segmentoId": ["Segmento ID", "segmento_id", "segmentoId"],
        "segmento": ["Segmento", "segmento"],
        "diretoriaId": ["Diretoria ID", "diretoria_id", "diretoriaId"],
        "diretoriaNome": ["Diretoria Nome", "Diretoria Regional", "diretoria_nome"],
        "gerenciaId": ["Gerencia Regional ID", "Gerencia ID", "gerencia_regional_id", "gerenciaId", "regional_id"],
        "gerenciaNome": ["Gerencia Regional Nome", "Regional Nome", "gerencia_regional_nome", "gerenciaNome"],
        "agenciaId": ["Agencia ID", "Agência ID", "agencia_id", "agenciaId"],
        "agenciaNome": ["Agencia Nome", "Agência Nome", "agencia_nome"],
        "agenciaCodigo": ["Agencia Codigo", "Agência Codigo", "Codigo Agencia", "agencia_codigo"],
        "gerenteGestaoId": ["Gerente Gestao ID", "gerente_gestao_id", "GerenteGestaoId"],
        "gerenteGestaoNome": ["Gerente Gestao Nome", "Gerente de Gestao", "Gerente Gestao", "gerente_gestao_nome"],
        "gerenteId": ["Gerente ID", "gerente_id", "GerenteId"],
        "gerenteNome": ["Gerente Nome", "Gerente", "gerente_nome", "Gerente Geral", "Gerente geral"]
      },
      "produto": {
        "familiaId": ["Familia ID", "familia_id", "Familia"],
        "familiaNome": ["Familia Nome", "familia_nome", "Família Nome", "Familia"],
        "indicadorId": ["ID Indicador", "Indicador ID", "id_indicador", "Indicador"],
        "indicadorNome": ["Indicador Nome", "ds_indicador", "Indicador"],
        "subId": ["Subindicador ID", "id_subindicador", "Sub Produto ID", "Subproduto ID", "Subproduto"],
        "subNome": ["Subindicador Nome", "subindicador", "Subproduto", "Sub Produto"]
      },
      "vendas": {
        "carteira": ["Carteira", "carteira"],
        "canalVenda": ["Canal Venda", "Canal", "canal_venda"],
        "tipoVenda": ["Tipo Venda", "tipo_venda", "Tipo"],
        "modalidadePagamento": ["Modalidade Pagamento", "modalidade_pagamento", "Modalidade"]
      },
      "datas": {
        "data": ["Data", "Data Movimento", "data"],
        "competencia": ["Competencia", "competencia", "Competência"],
        "dataVencimento": ["Data Vencimento", "data_vencimento"],
        "dataCancelamento": ["Data Cancelamento", "data_cancelamento"]
      },
      "valores": {
        "valorMeta": ["Valor Meta", "Meta", "meta", "meta_mensal", "meta_contrato", "metaValor"],
        "valorRealizado": ["Valor Realizado", "Realizado", "realizado", "real_mensal", "valor_realizado", "realizadoValor"],
        "quantidade": ["Quantidade", "Qtd", "quantidade", "Quantidade Contrato"],
        "peso": ["Peso", "peso", "pontos_meta", "Pontos Meta"],
        "pontos": ["Pontos", "pontos", "pontos_cumpridos", "Pontos Cumpridos"],
        "statusId": ["Status ID", "status_id", "Status"],
        "motivoCancelamento": ["Motivo Cancelamento", "motivo_cancelamento", "Motivo"]
      }
    }
  },
  "historico": {
    "nome": "FACT_HISTORICO_RANKING_POBJ",
    "descricao": "Histórico de ranking POBJ",
    "obrigatorias": [
      "nivel"
    ],
    "colunas": {
      "identificacao": {
        "nivel": ["nivel", "Nivel", "Nível", "level"],
        "ano": ["ano", "Ano", "year", "Year"],
        "database": ["database", "competencia", "Competencia", "data", "Data"]
      },
      "estrutura": {
        "segmento": ["segmento", "Segmento"],
        "segmentoId": ["segmentoId", "SegmentoId", "segmento_id", "Id Segmento"],
        "diretoria": ["diretoria", "Diretoria", "diretoriaId", "DiretoriaId", "ID Diretoria"],
        "diretoriaNome": ["diretoriaNome", "DiretoriaNome", "Diretoria Nome", "diretoria_nome"],
        "gerenciaRegional": ["gerenciaRegional", "GerenciaRegional", "gerencia", "Gerencia", "Gerencia ID"],
        "gerenciaNome": ["gerenciaNome", "GerenciaNome", "Regional Nome", "regionalNome"],
        "agencia": ["agencia", "Agencia", "agenciaId", "AgenciaId"],
        "agenciaNome": ["agenciaNome", "AgenciaNome", "Agencia Nome"],
        "agenciaCodigo": ["agenciaCodigo", "AgenciaCodigo", "Codigo Agencia", "Agencia Codigo"],
        "gerenteGestao": ["gerenteGestao", "GerenteGestao", "gerenteGestaoId", "GerenteGestaoId", "gerente_gestao_id"],
        "gerenteGestaoNome": ["gerenteGestaoNome", "GerenteGestaoNome", "Gerente Gestao Nome", "Gerente de Gestao Nome", "Gerente de Gestão Nome", "gerente_gestao_nome"],
        "gerente": ["gerente", "Gerente", "gerenteId", "GerenteId"],
        "gerenteNome": ["gerenteNome", "GerenteNome", "Gerente Nome"]
      },
      "ranking": {
        "participantes": ["participantes", "Participantes", "totalParticipantes"],
        "rank": ["rank", "Rank", "posicao", "posição", "classificacao"],
        "pontos": ["pontos", "Pontos", "pontuacao", "Pontuacao", "p_acum"]
      }
    },
    "notas": {
      "nivel": "Valores aceitos: 'diretoria', 'gerencia', 'agencia', 'gerente'"
    }
  },
  "leads": {
    "nome": "OPPORTUNITY_LEADS",
    "descricao": "Leads de oportunidades",
    "obrigatorias": [],
    "nota": "Ver arquivo public/js/leads.js função normalizarLinhasLeads para detalhes completos"
  }
}
```

## Mapeamento Banco de Dados → API

```json
{
  "tabelas": {
    "f_realizados": "realizados",
    "f_metas": "metas",
    "f_variavel": "variavel",
    "d_mesu": "mesu",
    "d_produtos": "produtos",
    "d_calendario": "calendario",
    "f_campanhas": "campanhas",
    "f_detalhes": "detalhes",
    "f_historico_ranking_pobj": "historico"
  }
}
```

## Chaves Principais (Resumo)

```json
{
  "realizados": {
    "chaves_obrigatorias": ["Registro ID", "id_indicador"],
    "chaves_principais": [
      "Registro ID",
      "id_indicador",
      "Segmento ID",
      "Diretoria ID",
      "Gerencia ID",
      "Agencia ID",
      "Gerente Gestao ID",
      "Gerente ID",
      "Familia ID",
      "Produto ID",
      "Data",
      "Competencia",
      "Realizado Mensal",
      "Variavel Real"
    ]
  },
  "metas": {
    "chaves_obrigatorias": ["Registro ID"],
    "chaves_principais": [
      "Registro ID",
      "Segmento ID",
      "Diretoria ID",
      "Gerencia ID",
      "Agencia ID",
      "Gerente Gestao ID",
      "Gerente ID",
      "Familia ID",
      "id_indicador",
      "Data",
      "Competencia",
      "Meta Mensal",
      "Variavel Meta",
      "Peso"
    ]
  },
  "variavel": {
    "chaves_obrigatorias": ["Registro ID"],
    "chaves_principais": [
      "Registro ID",
      "id_indicador",
      "Familia ID",
      "Data",
      "Competencia",
      "Variavel Meta",
      "Variavel Real"
    ]
  },
  "mesu": {
    "chaves_obrigatorias": [],
    "chaves_principais": [
      "Segmento ID",
      "Diretoria ID",
      "Regional ID",
      "Agencia ID",
      "Gerente Gestao ID",
      "Gerente ID",
      "Segmento Nome",
      "Diretoria Nome",
      "Regional Nome",
      "Agencia Nome",
      "Gerente Gestao Nome",
      "Gerente Nome"
    ]
  },
  "produtos": {
    "chaves_obrigatorias": [],
    "chaves_principais": [
      "Familia ID",
      "Familia Slug",
      "Familia Nome",
      "Indicador ID",
      "Indicador Slug",
      "Indicador Nome",
      "Subindicador ID",
      "Subindicador Slug",
      "Subindicador Nome"
    ]
  },
  "calendario": {
    "chaves_obrigatorias": ["Data"],
    "chaves_principais": [
      "Data",
      "Competencia",
      "Ano",
      "Mes",
      "Mes Nome",
      "Dia",
      "Dia da Semana",
      "Eh Dia Util"
    ]
  },
  "campanhas": {
    "chaves_obrigatorias": ["Campanha ID", "id_indicador"],
    "chaves_principais": [
      "Campanha ID",
      "Sprint ID",
      "Diretoria ID",
      "Gerencia ID",
      "Agencia ID",
      "id_indicador",
      "Linhas",
      "Cash",
      "Conquista",
      "Data",
      "Competencia"
    ]
  },
  "detalhes": {
    "chaves_obrigatorias": ["Contrato ID", "Registro ID"],
    "chaves_principais": [
      "Contrato ID",
      "Registro ID",
      "Segmento ID",
      "Diretoria ID",
      "Gerencia ID",
      "Agencia ID",
      "Indicador ID",
      "Data",
      "Competencia",
      "Valor Meta",
      "Valor Realizado",
      "Peso",
      "Pontos"
    ]
  },
  "historico": {
    "chaves_obrigatorias": ["nivel"],
    "chaves_principais": [
      "nivel",
      "ano",
      "competencia",
      "Segmento ID",
      "Diretoria ID",
      "Gerencia ID",
      "Agencia ID",
      "rank",
      "pontos",
      "participantes"
    ]
  }
}
```

## Notas Importantes

```json
{
  "formatos": {
    "data": {
      "formato": "ISO (YYYY-MM-DD)",
      "exemplo": "2025-01-15"
    },
    "numeros": {
      "tipo": "number ou string numérica",
      "conversao": "toNumber() no JavaScript"
    },
    "booleanos": {
      "tipo": "boolean ou string",
      "conversao": "converterBooleano() no JavaScript"
    }
  },
  "regras": {
    "caseSensitive": false,
    "nomesAlternativos": "JavaScript aceita múltiplos nomes para mesma coluna",
    "obrigatorias": "Colunas marcadas como obrigatórias não podem ser nulas/vazias"
  }
}
```
