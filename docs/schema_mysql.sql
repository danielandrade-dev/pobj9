-- POBJ.d_calendario definição

CREATE TABLE `d_calendario` (
  `data` date NOT NULL,
  `ano` int(11) NOT NULL,
  `mes` tinyint(4) NOT NULL,
  `mes_nome` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia` tinyint(4) NOT NULL,
  `dia_da_semana` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semana` tinyint(4) NOT NULL,
  `trimestre` tinyint(4) NOT NULL,
  `semestre` tinyint(4) NOT NULL,
  `eh_dia_util` tinyint(1) NOT NULL,
  PRIMARY KEY (`data`),
  KEY `idx_d_calendario_mes` (`ano`,`mes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.d_estrutura definição

CREATE TABLE `d_estrutura` (
  `funcional` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `agencia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_agencia` int(11) DEFAULT NULL,
  `porte` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_regional` int(11) DEFAULT NULL,
  `diretoria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_diretoria` int(11) DEFAULT NULL,
  `segmento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_segmento` int(11) DEFAULT NULL,
  `rede` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`funcional`),
  UNIQUE KEY `uq_d_estrutura_funcional` (`funcional`),
  KEY `ix_estru_seg` (`id_segmento`),
  KEY `ix_estru_dir` (`id_diretoria`),
  KEY `ix_estru_reg` (`id_regional`),
  KEY `ix_estru_age` (`id_agencia`),
  KEY `ix_estru_cgo` (`cargo`),
  KEY `ix_estrutura_cargo` (`cargo`),
  KEY `ix_estrutura_agencia` (`id_agencia`),
  KEY `ix_estrutura_regional` (`id_regional`),
  KEY `ix_estrutura_diretoria` (`id_diretoria`),
  KEY `ix_estrutura_segmento` (`id_segmento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.d_mapa_unidade definição

CREATE TABLE `d_mapa_unidade` (
  `tipo` enum('DR','GR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_destino` int(11) NOT NULL,
  PRIMARY KEY (`tipo`,`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.d_produtos definição

CREATE TABLE `d_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_familia` int(11) NOT NULL,
  `familia` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_indicador` int(11) NOT NULL,
  `indicador` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_subindicador` int(11) DEFAULT NULL,
  `subindicador` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_prod_ind_sub` (`id_indicador`,`id_subindicador`),
  KEY `idx_prod_familia` (`id_familia`),
  KEY `idx_prod_indicador` (`id_indicador`),
  KEY `idx_prod_subindicador` (`id_subindicador`),
  KEY `idx_prod_ind_sub` (`id_indicador`,`id_subindicador`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.d_status_indicadores definição

CREATE TABLE `d_status_indicadores` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_d_status_nome` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.d_unidade definição

CREATE TABLE `d_unidade` (
  `segmento_id` smallint(5) unsigned NOT NULL,
  `segmento` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segmento_label` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diretoria_id` smallint(5) unsigned NOT NULL,
  `diretoria` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diretoria_label` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regional_id` smallint(5) unsigned NOT NULL,
  `regional` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regional_label` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agencia_id` smallint(5) unsigned NOT NULL,
  `agencia` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agencia_label` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gerente_id` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao_id` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `porte` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`agencia_id`),
  KEY `ix_unidade_path` (`segmento_id`,`diretoria_id`,`regional_id`),
  KEY `ix_unidade_reg_ag` (`regional_id`,`agencia_id`),
  KEY `ix_unidade_diretoria` (`diretoria_id`),
  KEY `ix_unidade_segmento` (`segmento_id`),
  KEY `ix_unid_gerente` (`gerente_id`),
  KEY `ix_unid_gerente_gestao` (`gerente_gestao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.f_pontos definição

CREATE TABLE `f_pontos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `funcional` varchar(20) NOT NULL,
  `id_indicador` int(11) NOT NULL,
  `indicador` varchar(150) NOT NULL,
  `meta` decimal(18,2) NOT NULL DEFAULT '0.00',
  `realizado` decimal(18,2) NOT NULL DEFAULT '0.00',
  `dt_atualizacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_fp_funcional` (`funcional`),
  KEY `idx_fp_indicador` (`id_indicador`),
  KEY `idx_fp_dt` (`dt_atualizacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- POBJ.f_variavel definição

CREATE TABLE `f_variavel` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `funcional` varchar(20) NOT NULL,
  `meta` decimal(18,2) NOT NULL DEFAULT '0.00',
  `variavel` decimal(18,2) NOT NULL DEFAULT '0.00',
  `dt_atualizacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_fv_funcional` (`funcional`),
  KEY `idx_fv_dt` (`dt_atualizacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- POBJ.omega_departamentos definição

CREATE TABLE `omega_departamentos` (
  `departamento` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departamento_id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordem_departamento` int(11) DEFAULT NULL,
  `tipo` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordem_tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`departamento`,`tipo`),
  UNIQUE KEY `uq_omega_departamento_id` (`departamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.omega_usuarios definição

CREATE TABLE `omega_usuarios` (
  `id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `funcional` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricula` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario` tinyint(1) DEFAULT '1',
  `analista` tinyint(1) DEFAULT '0',
  `supervisor` tinyint(1) DEFAULT '0',
  `admin` tinyint(1) DEFAULT '0',
  `encarteiramento` tinyint(1) DEFAULT '0',
  `meta` tinyint(1) DEFAULT '0',
  `orcamento` tinyint(1) DEFAULT '0',
  `pobj` tinyint(1) DEFAULT '0',
  `matriz` tinyint(1) DEFAULT '0',
  `outros` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.f_campanhas definição

CREATE TABLE `f_campanhas` (
  `campanha_id` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sprint_id` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diretoria_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diretoria_nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gerencia_regional_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regional_nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agencia_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agencia_nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gerente_gestao_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segmento_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `familia_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_indicador` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ds_indicador` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subproduto` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_subindicador` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `carteira` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linhas` decimal(18,2) DEFAULT NULL,
  `cash` decimal(18,2) DEFAULT NULL,
  `conquista` decimal(18,2) DEFAULT NULL,
  `atividade` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` date NOT NULL,
  `familia_codigo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indicador_codigo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subindicador_codigo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`campanha_id`),
  KEY `idx_f_campanhas_data` (`data`),
  KEY `idx_f_campanhas_diretoria` (`diretoria_id`),
  KEY `idx_f_campanhas_gerencia` (`gerencia_regional_id`),
  KEY `idx_f_campanhas_indicador` (`id_indicador`),
  KEY `idx_f_campanhas_unidade` (`segmento_id`,`diretoria_id`,`gerencia_regional_id`,`agencia_id`),
  KEY `fk_campanhas_produtos` (`id_indicador`,`id_subindicador`),
  CONSTRAINT `fk_campanhas_calendario_data` FOREIGN KEY (`data`) REFERENCES `d_calendario` (`data`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.f_detalhes definição

CREATE TABLE `f_detalhes` (
  `contrato_id` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registro_id` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segmento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmento_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diretoria_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diretoria_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerencia_regional_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gerencia_regional_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agencia_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agencia_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `familia_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `familia_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_indicador` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ds_indicador` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_subindicador` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `subindicador` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carteira` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canal_venda` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_venda` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modalidade_pagamento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` date NOT NULL,
  `competencia` date NOT NULL,
  `valor_meta` decimal(18,2) DEFAULT NULL,
  `valor_realizado` decimal(18,2) DEFAULT NULL,
  `quantidade` decimal(18,4) DEFAULT NULL,
  `peso` decimal(18,4) DEFAULT NULL,
  `pontos` decimal(18,4) DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `data_cancelamento` date DEFAULT NULL,
  `motivo_cancelamento` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`contrato_id`),
  KEY `idx_f_detalhes_registro` (`registro_id`),
  KEY `idx_f_detalhes_indicador` (`id_indicador`,`id_subindicador`),
  KEY `idx_f_detalhes_unidade` (`segmento_id`,`diretoria_id`,`gerencia_regional_id`,`agencia_id`),
  KEY `idx_f_detalhes_data` (`data`),
  KEY `idx_f_detalhes_competencia` (`competencia`),
  KEY `fk_detalhes_status` (`status_id`),
  CONSTRAINT `fk_detalhes_calendario_comp` FOREIGN KEY (`competencia`) REFERENCES `d_calendario` (`data`),
  CONSTRAINT `fk_detalhes_calendario_data` FOREIGN KEY (`data`) REFERENCES `d_calendario` (`data`),
  CONSTRAINT `fk_detalhes_status` FOREIGN KEY (`status_id`) REFERENCES `d_status_indicadores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.f_historico_ranking_pobj definição

CREATE TABLE `f_historico_ranking_pobj` (
  `nivel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ano` int(11) NOT NULL,
  `database` date NOT NULL,
  `segmento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmento_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diretoria` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diretoria_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerencia_regional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerencia_regional_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agencia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agencia_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `participantes` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `pontos` decimal(18,2) DEFAULT NULL,
  `realizado` decimal(18,2) DEFAULT NULL,
  `meta` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`nivel`,`ano`,`database`),
  KEY `idx_f_hist_calendario` (`database`),
  KEY `idx_f_hist_unidade` (`segmento_id`,`diretoria`,`gerencia_regional`,`agencia`),
  KEY `idx_f_hist_ranking_diretoria` (`diretoria`),
  KEY `idx_f_hist_ranking_segmento` (`segmento_id`),
  CONSTRAINT `fk_hist_calendario` FOREIGN KEY (`database`) REFERENCES `d_calendario` (`data`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.f_leads_propensos definição

CREATE TABLE `f_leads_propensos` (
  `database` date NOT NULL,
  `nome_empresa` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnae` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmento_cliente` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segmento_cliente_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `produto_propenso` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `familia_produto_propenso` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secao_produto_propenso` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_indicador` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_subindicador` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `data_contato` date DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `responsavel_contato` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diretoria_cliente` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diretoria_cliente_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regional_cliente` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regional_cliente_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agencia_cliente` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agencia_cliente_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao_cliente` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao_cliente_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_cliente` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_cliente_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credito_pre_aprovado` decimal(18,2) DEFAULT NULL,
  `origem_lead` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`database`,`nome_empresa`),
  KEY `idx_f_leads_calendario` (`database`),
  KEY `idx_f_leads_contato` (`data_contato`),
  KEY `idx_f_leads_unidade` (`segmento_cliente_id`,`diretoria_cliente_id`,`regional_cliente_id`,`agencia_cliente_id`),
  KEY `idx_f_leads_produto` (`id_indicador`,`id_subindicador`),
  KEY `idx_f_leads_diretoria` (`diretoria_cliente_id`),
  KEY `idx_f_leads_regional` (`regional_cliente_id`),
  CONSTRAINT `fk_leads_calendario_base` FOREIGN KEY (`database`) REFERENCES `d_calendario` (`data`) ON DELETE CASCADE,
  CONSTRAINT `fk_leads_calendario_contato` FOREIGN KEY (`data_contato`) REFERENCES `d_calendario` (`data`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.f_meta definição

CREATE TABLE `f_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data_meta` date NOT NULL,
  `funcional` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_mensal` decimal(18,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_familia` int(11) DEFAULT NULL,
  `id_indicador` int(11) DEFAULT NULL,
  `id_subindicador` int(11) DEFAULT NULL,
  `segmento_id` int(11) DEFAULT NULL,
  `diretoria_id` int(11) DEFAULT NULL,
  `gerencia_regional_id` int(11) DEFAULT NULL,
  `agencia_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_meta_data` (`data_meta`),
  KEY `ix_meta_func_data` (`funcional`,`data_meta`),
  KEY `ix_meta_prod` (`id_familia`,`id_indicador`,`id_subindicador`),
  KEY `ix_meta_mesu` (`segmento_id`,`diretoria_id`,`gerencia_regional_id`,`agencia_id`),
  KEY `idx_fm_ind_sub` (`id_indicador`,`id_subindicador`),
  KEY `idx_fm_date` (`data_meta`),
  CONSTRAINT `fk_f_meta__d_estrutura` FOREIGN KEY (`funcional`) REFERENCES `d_estrutura` (`funcional`) ON UPDATE CASCADE,
  CONSTRAINT `fk_f_meta__prod_ind_sub` FOREIGN KEY (`id_indicador`, `id_subindicador`) REFERENCES `d_produtos` (`id_indicador`, `id_subindicador`) ON UPDATE CASCADE,
  CONSTRAINT `fk_fm_cal` FOREIGN KEY (`data_meta`) REFERENCES `d_calendario` (`data`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.f_realizados definição

CREATE TABLE `f_realizados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_contrato` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_realizado` date NOT NULL,
  `funcional` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `realizado` decimal(18,2) NOT NULL DEFAULT '0.00',
  `familia_id` int(11) DEFAULT NULL,
  `indicador_id` int(11) DEFAULT NULL,
  `subindicador_id` int(11) DEFAULT NULL,
  `segmento_id` int(11) DEFAULT NULL,
  `diretoria_id` int(11) DEFAULT NULL,
  `gerencia_regional_id` int(11) DEFAULT NULL,
  `agencia_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_real_data` (`data_realizado`),
  KEY `ix_real_func_data` (`funcional`,`data_realizado`),
  KEY `ix_real_contrato` (`id_contrato`),
  KEY `ix_real_prod` (`familia_id`,`indicador_id`,`subindicador_id`),
  KEY `ix_real_mesu` (`segmento_id`,`diretoria_id`,`gerencia_regional_id`,`agencia_id`),
  KEY `ix_realizado_data_ind` (`data_realizado`,`indicador_id`,`subindicador_id`),
  KEY `ix_realizado_hierarquia` (`segmento_id`,`diretoria_id`,`gerencia_regional_id`,`agencia_id`),
  KEY `ix_realizado_funcional_data` (`funcional`,`data_realizado`),
  KEY `idx_fr_ind_sub` (`indicador_id`,`subindicador_id`),
  KEY `idx_fr_date` (`data_realizado`),
  CONSTRAINT `fk_f_realizado__d_estrutura` FOREIGN KEY (`funcional`) REFERENCES `d_estrutura` (`funcional`) ON UPDATE CASCADE,
  CONSTRAINT `fk_f_realizado__prod_ind_sub` FOREIGN KEY (`indicador_id`, `subindicador_id`) REFERENCES `d_produtos` (`id_indicador`, `id_subindicador`) ON UPDATE CASCADE,
  CONSTRAINT `fk_fr_cal` FOREIGN KEY (`data_realizado`) REFERENCES `d_calendario` (`data`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.omega_status definição

CREATE TABLE `omega_status` (
  `id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'neutral',
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `departamento_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_omega_status_departamento` (`departamento_id`),
  CONSTRAINT `fk_omega_status_departamento` FOREIGN KEY (`departamento_id`) REFERENCES `omega_departamentos` (`departamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- POBJ.omega_chamados definição

CREATE TABLE `omega_chamados` (
  `id` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_label` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `queue` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opened` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `requester_id` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_id` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `history` longtext COLLATE utf8mb4_unicode_ci,
  `diretoria` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerencia` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agencia` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente_gestao` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gerente` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_omega_chamados_status` (`status`),
  KEY `idx_omega_chamados_team` (`team_id`),
  KEY `idx_omega_chamados_requester` (`requester_id`),
  KEY `idx_omega_chamados_owner` (`owner_id`),
  CONSTRAINT `fk_omega_chamados_owner` FOREIGN KEY (`owner_id`) REFERENCES `omega_usuarios` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_omega_chamados_requester` FOREIGN KEY (`requester_id`) REFERENCES `omega_usuarios` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_omega_chamados_status` FOREIGN KEY (`status`) REFERENCES `omega_status` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_omega_chamados_team` FOREIGN KEY (`team_id`) REFERENCES `omega_departamentos` (`departamento_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;