<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Pobj\Api\Database\DatabaseConnection;

$pdo = DatabaseConnection::getConnection();

echo "Populando banco de dados com dados completos para testes...\n\n";

try {
    $pdo->beginTransaction();

    // 1. Limpar dados existentes (opcional - comentado para não perder dados importantes)
    // echo "Limpando dados existentes...\n";
    // $pdo->exec("DELETE FROM f_leads_propensos");
    // $pdo->exec("DELETE FROM f_historico_ranking_pobj");
    // $pdo->exec("DELETE FROM f_detalhes");
    // $pdo->exec("DELETE FROM f_campanhas");
    // $pdo->exec("DELETE FROM f_variavel");
    // $pdo->exec("DELETE FROM f_meta");
    // $pdo->exec("DELETE FROM f_realizados");
    // $pdo->exec("DELETE FROM d_calendario WHERE ano >= 2025");
    // echo "Dados limpos.\n\n";

    // 3. Popular d_status_indicadores
    echo "Populando d_status_indicadores...\n";
    $status = [
        ['id' => '01', 'status' => 'Atingido'],
        ['id' => '02', 'status' => 'Não Atingido'],
        ['id' => '03', 'status' => 'Todos'],
    ];

    $stmtStatus = $pdo->prepare("
        INSERT INTO d_status_indicadores (id, status)
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE status = VALUES(status)
    ");

    foreach ($status as $s) {
        $stmtStatus->execute([$s['id'], $s['status']]);
    }
    echo "✓ d_status_indicadores populada\n";

    // 4. Popular d_produtos
    echo "Populando d_produtos...\n";
    $produtos = [
        ['id_familia' => 1, 'familia' => 'Relacionamento',
         'id_indicador' => 1, 'indicador' => 'Cash - Contas a Pagar e Contas a Receber',
         'id_subindicador' => 2, 'subindicador' => 'Contas a Pagar', 'peso' => 0.15],
        ['id_familia' => 1, 'familia' => 'Relacionamento',
         'id_indicador' => 1, 'indicador' => 'Cash - Contas a Pagar e Contas a Receber',
         'id_subindicador' => 3, 'subindicador' => 'Contas a Receber', 'peso' => 0.15],
        ['id_familia' => 1, 'familia' => 'Relacionamento',
         'id_indicador' => 2, 'indicador' => 'Novas Aquisições Alelo',
         'id_subindicador' => 0, 'subindicador' => null, 'peso' => 0.20],
        ['id_familia' => 2, 'familia' => 'Crédito',
         'id_indicador' => 3, 'indicador' => 'Produção de Crédito PJ',
         'id_subindicador' => 5, 'subindicador' => 'Linha PJ', 'peso' => 0.25],
        ['id_familia' => 3, 'familia' => 'Captação',
         'id_indicador' => 4, 'indicador' => 'Captação Bruta',
         'id_subindicador' => 1, 'subindicador' => 'CDB e Isentos', 'peso' => 0.25],
    ];

    $stmtProduto = $pdo->prepare("
        INSERT INTO d_produtos (id_familia, familia, id_indicador, indicador, id_subindicador, subindicador, peso)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            familia = VALUES(familia),
            indicador = VALUES(indicador),
            subindicador = VALUES(subindicador),
            peso = VALUES(peso)
    ");

    foreach ($produtos as $prod) {
        $stmtProduto->execute([
            $prod['id_familia'], $prod['familia'],
            $prod['id_indicador'], $prod['indicador'],
            $prod['id_subindicador'], $prod['subindicador'],
            $prod['peso']
        ]);
    }
    echo "✓ d_produtos populada\n";

    // 5. Popular d_calendario (2025 completo)
    echo "Populando d_calendario para 2025...\n";
    $stmtCalendario = $pdo->prepare("
        INSERT INTO d_calendario (
            data, ano, mes, mes_nome, dia, dia_da_semana,
            semana, trimestre, semestre, eh_dia_util
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            ano = VALUES(ano),
            mes = VALUES(mes),
            mes_nome = VALUES(mes_nome),
            dia = VALUES(dia),
            dia_da_semana = VALUES(dia_da_semana),
            semana = VALUES(semana),
            trimestre = VALUES(trimestre),
            semestre = VALUES(semestre),
            eh_dia_util = VALUES(eh_dia_util)
    ");

    $meses = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
    ];
    $diasSemana = ['domingo', 'segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'];
    $feriados = ['2025-01-01', '2025-04-18', '2025-04-21', '2025-05-01', '2025-06-19', '2025-09-07', '2025-10-12', '2025-11-02', '2025-11-15', '2025-11-20', '2025-12-25'];

    $ano = 2025;
    $semana = 1;
    $trimestre = 1;
    $semestre = 1;

    for ($mes = 1; $mes <= 12; $mes++) {
        $diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $trimestre = (int)ceil($mes / 3);
        $semestre = $mes <= 6 ? 1 : 2;

        for ($dia = 1; $dia <= $diasNoMes; $dia++) {
            $data = sprintf('%04d-%02d-%02d', $ano, $mes, $dia);
            $timestamp = strtotime($data);
            $diaSemana = $diasSemana[(int)date('w', $timestamp)];
            $ehDiaUtil = !in_array($data, $feriados) && $diaSemana !== 'sábado' && $diaSemana !== 'domingo';

            if ($dia === 1 || ($diaSemana === 'segunda-feira' && $dia > 1)) {
                $semana++;
            }

            $stmtCalendario->execute([
                $data, $ano, $mes, $meses[$mes], $dia, $diaSemana,
                $semana, $trimestre, $semestre, $ehDiaUtil ? 1 : 0
            ]);
        }
    }
    echo "✓ d_calendario populada\n";

    // 5.5. Popular d_estrutura (funcionais necessários)
    echo "Populando d_estrutura...\n";
    $stmtEstrutura = $pdo->prepare("
        INSERT INTO d_estrutura (
            funcional, nome, cargo, id_cargo,
            agencia, id_agencia, porte,
            regional, id_regional,
            diretoria, id_diretoria,
            segmento, id_segmento, rede
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            nome = VALUES(nome),
            cargo = VALUES(cargo),
            agencia = VALUES(agencia),
            id_agencia = VALUES(id_agencia),
            porte = VALUES(porte),
            regional = VALUES(regional),
            id_regional = VALUES(id_regional),
            diretoria = VALUES(diretoria),
            id_diretoria = VALUES(id_diretoria),
            segmento = VALUES(segmento),
            id_segmento = VALUES(id_segmento)
    ");

    $funcionais = [
        ['funcional' => 'FUNC1141', 'nome' => 'Funcionário Campo Limpo 1', 'cargo' => 'Gerente', 'id_cargo' => 1,
         'agencia' => 'Campo Limpo 1', 'id_agencia' => 1141, 'porte' => 'Grande',
         'regional' => 'SP Sul/Oeste', 'id_regional' => 8486,
         'diretoria' => 'Empresas', 'id_diretoria' => 8607,
         'segmento' => 'Empresas', 'id_segmento' => 1, 'rede' => 'SP'],
        ['funcional' => 'FUNC1267', 'nome' => 'Funcionário Faria Lima 2', 'cargo' => 'Gerente', 'id_cargo' => 1,
         'agencia' => 'Faria Lima 2', 'id_agencia' => 1267, 'porte' => 'Grande',
         'regional' => 'SP Sul/Oeste', 'id_regional' => 8486,
         'diretoria' => 'Empresas', 'id_diretoria' => 8607,
         'segmento' => 'Empresas', 'id_segmento' => 1, 'rede' => 'SP'],
        ['funcional' => 'FUNC7378', 'nome' => 'Funcionário Faria Lima 1', 'cargo' => 'Gerente', 'id_cargo' => 1,
         'agencia' => 'Faria Lima 1', 'id_agencia' => 7378, 'porte' => 'Grande',
         'regional' => 'SP Sul e Oeste', 'id_regional' => 8684,
         'diretoria' => 'Empresas', 'id_diretoria' => 8607,
         'segmento' => 'Empresas', 'id_segmento' => 1, 'rede' => 'SP'],
        ['funcional' => 'FUNC3336', 'nome' => 'Funcionário Salvador', 'cargo' => 'Gerente', 'id_cargo' => 1,
         'agencia' => 'Salvador', 'id_agencia' => 3336, 'porte' => 'Médio',
         'regional' => 'Nordeste', 'id_regional' => 8487,
         'diretoria' => 'Empresas', 'id_diretoria' => 8607,
         'segmento' => 'Empresas', 'id_segmento' => 1, 'rede' => 'NE'],
        ['funcional' => 'FUNC1697', 'nome' => 'Funcionário Itajaí', 'cargo' => 'Gerente', 'id_cargo' => 1,
         'agencia' => 'Itajaí - SC', 'id_agencia' => 1697, 'porte' => 'Médio',
         'regional' => 'SUL', 'id_regional' => 8485,
         'diretoria' => 'Empresas', 'id_diretoria' => 8607,
         'segmento' => 'Empresas', 'id_segmento' => 1, 'rede' => 'SUL'],
    ];

    foreach ($funcionais as $func) {
        $stmtEstrutura->execute([
            $func['funcional'], $func['nome'], $func['cargo'], $func['id_cargo'],
            $func['agencia'], $func['id_agencia'], $func['porte'],
            $func['regional'], $func['id_regional'],
            $func['diretoria'], $func['id_diretoria'],
            $func['segmento'], $func['id_segmento'], $func['rede']
        ]);
    }
    echo "✓ d_estrutura populada\n";

    // 6. Popular f_realizados (dados de novembro 2025)
    echo "Populando f_realizados...\n";
    $stmtRealizado = $pdo->prepare("
        INSERT INTO f_realizados (
            id_contrato, data_realizado, funcional, realizado,
            familia_id, indicador_id, subindicador_id,
            segmento_id, diretoria_id, gerencia_regional_id, agencia_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $agencias = [1141, 1267];
    $indicador = 2; // Novas Aquisições Alelo (id_indicador = 2, id_subindicador = null/0)
    $familia = 1; // Relacionamento
    $valores = [14000, 16000, 18000];

    for ($dia = 1; $dia <= 8; $dia++) {
        $data = sprintf('2025-11-%02d', $dia);
        foreach ($agencias as $idx => $agencia) {
            $valor = $valores[$idx % count($valores)];
            $funcional = sprintf('FUNC%04d', $agencia);
            
            $idContrato = substr(sprintf('CONT-%s-%d', str_replace('-', '', $data), $agencia), 0, 10);
            $stmtRealizado->execute([
                $idContrato,
                $data,
                $funcional,
                $valor,
                $familia,
                $indicador,
                0, // subindicador_id 0 para Novas Aquisições Alelo
                1, // segmento_id Empresas
                8607, // diretoria_id Empresas
                8486, // gerencia_regional_id SP Sul/Oeste
                $agencia
            ]);
        }
    }
    echo "✓ f_realizados populada\n";

    // 7. Popular f_meta
    echo "Populando f_meta...\n";
    $stmtMeta = $pdo->prepare("
        INSERT INTO f_meta (
            data_meta, funcional, meta_mensal,
            id_familia, id_indicador, id_subindicador,
            segmento_id, diretoria_id, gerencia_regional_id, agencia_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($agencias as $agencia) {
        $data = '2025-11-01';
        $funcional = sprintf('FUNC%04d', $agencia);
        
        $stmtMeta->execute([
            $data,
            $funcional,
            650000,
            $familia,
            $indicador,
            0,
            1,
            8607,
            8486,
            $agencia
        ]);
    }
    echo "✓ f_meta populada\n";

    // 8. Popular f_variavel
    echo "Populando f_variavel...\n";
    $stmtVariavel = $pdo->prepare("
        INSERT INTO f_variavel (funcional, meta, variavel, dt_atualizacao)
        VALUES (?, ?, ?, ?)
    ");

    $variaveis = [
        ['funcional' => 'FUNC1141', 'meta' => 1000, 'variavel' => 800],
        ['funcional' => 'FUNC1267', 'meta' => 1100, 'variavel' => 913],
        ['funcional' => 'FUNC7378', 'meta' => 1200, 'variavel' => 1272],
        ['funcional' => 'FUNC3336', 'meta' => 1300, 'variavel' => 1391],
        ['funcional' => 'FUNC1697', 'meta' => 1400, 'variavel' => 1624],
    ];

    $dataAtualizacao = '2025-11-15';
    foreach ($variaveis as $var) {
        $stmtVariavel->execute([
            $var['funcional'],
            $var['meta'],
            $var['variavel'],
            $dataAtualizacao
        ]);
    }
    echo "✓ f_variavel populada\n";

    // 9. Popular f_campanhas
    echo "Populando f_campanhas...\n";
    $stmtCampanha = $pdo->prepare("
        INSERT INTO f_campanhas (
            campanha_id, sprint_id, segmento, segmento_id,
            diretoria_id, diretoria_nome, gerencia_regional_id, regional_nome,
            agencia_id, agencia_nome, gerente_gestao_id, gerente_gestao_nome,
            gerente_id, gerente_nome, familia_id, id_indicador, ds_indicador,
            subproduto, id_subindicador, familia_codigo, indicador_codigo, subindicador_codigo,
            carteira, data, linhas, cash, conquista, atividade
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            sprint_id = VALUES(sprint_id),
            segmento = VALUES(segmento),
            diretoria_nome = VALUES(diretoria_nome),
            regional_nome = VALUES(regional_nome),
            agencia_nome = VALUES(agencia_nome),
            gerente_gestao_nome = VALUES(gerente_gestao_nome),
            gerente_nome = VALUES(gerente_nome),
            ds_indicador = VALUES(ds_indicador),
            subproduto = VALUES(subproduto),
            carteira = VALUES(carteira),
            linhas = VALUES(linhas),
            cash = VALUES(cash),
            conquista = VALUES(conquista),
            atividade = VALUES(atividade)
    ");

    $campanhas = [
        [
            'campanha_id' => 'CAMP-2025-10-SP',
            'sprint_id' => 'SPRINT-2025-10',
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria_id' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional_id' => '8684', 'regional_nome' => 'SP Sul e Oeste',
            'agencia_id' => '7378', 'agencia_nome' => 'Faria Lima 1',
            'gerente_gestao_id' => 'GG8684', 'gerente_gestao_nome' => 'Marcos Peixoto',
            'gerente_id' => 'GE7378', 'gerente_nome' => 'Gerente 7378',
            'familia_id' => 'ligadas', 'id_indicador' => 'cartoes', 'ds_indicador' => 'Cartões',
            'subproduto' => 'Cartão de Crédito Emissão Classic',
            'id_subindicador' => 'SUB006', 'subindicador_codigo' => 'SUB006', 'familia_codigo' => 'LIG001', 'indicador_codigo' => 'cartoes',
            'carteira' => 'Carteira Paulista Empresas',
            'data' => '2025-10-09',
            'linhas' => 21.3, 'cash' => 98750, 'conquista' => 15.2,
            'atividade' => 'Workshops presenciais'
        ],
        [
            'campanha_id' => 'CAMP-2025-10-NORDESTE',
            'sprint_id' => 'SPRINT-2025-10',
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria_id' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional_id' => '8487', 'regional_nome' => 'Nordeste',
            'agencia_id' => '3336', 'agencia_nome' => 'Salvador',
            'gerente_gestao_id' => 'GG8487', 'gerente_gestao_nome' => 'Rafael Carvalho',
            'gerente_id' => 'GE3336', 'gerente_nome' => 'Gerente 3336',
            'familia_id' => 'credito', 'id_indicador' => 'prod_credito_pj', 'ds_indicador' => 'Produção de Crédito PJ',
            'subproduto' => 'Linha PJ',
            'id_subindicador' => 'SUB005', 'subindicador_codigo' => 'SUB005', 'familia_codigo' => 'CRE001', 'indicador_codigo' => 'prod_credito_pj',
            'carteira' => 'Carteira Nordeste Prime',
            'data' => '2025-10-07',
            'linhas' => 19.8, 'cash' => 121500, 'conquista' => 16.4,
            'atividade' => 'Missões de crédito'
        ],
        [
            'campanha_id' => 'CAMP-2025-10-SUL',
            'sprint_id' => 'SPRINT-2025-10',
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria_id' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional_id' => '8485', 'regional_nome' => 'SUL',
            'agencia_id' => '1697', 'agencia_nome' => 'Itajaí - SC',
            'gerente_gestao_id' => 'GG8485', 'gerente_gestao_nome' => 'Aline Siqueira',
            'gerente_id' => 'GE1697', 'gerente_nome' => 'Gerente 1697',
            'familia_id' => 'captacao', 'id_indicador' => 'captacao_bruta', 'ds_indicador' => 'Captação Bruta',
            'subproduto' => 'CDB e Isentos',
            'id_subindicador' => 'SUB001', 'subindicador_codigo' => 'SUB001', 'familia_codigo' => 'CAP001', 'indicador_codigo' => 'captacao_bruta',
            'carteira' => 'Carteira Atlas Empresas',
            'data' => '2025-10-05',
            'linhas' => 24.5, 'cash' => 158000, 'conquista' => 18.75,
            'atividade' => 'Rodadas consultivas'
        ],
    ];

    foreach ($campanhas as $camp) {
        $stmtCampanha->execute([
            $camp['campanha_id'], $camp['sprint_id'], $camp['segmento'], $camp['segmento_id'],
            $camp['diretoria_id'], $camp['diretoria_nome'], $camp['gerencia_regional_id'], $camp['regional_nome'],
            $camp['agencia_id'], $camp['agencia_nome'], $camp['gerente_gestao_id'], $camp['gerente_gestao_nome'],
            $camp['gerente_id'], $camp['gerente_nome'], $camp['familia_id'], $camp['id_indicador'], $camp['ds_indicador'],
            $camp['subproduto'], $camp['id_subindicador'], $camp['familia_codigo'], $camp['indicador_codigo'], $camp['subindicador_codigo'],
            $camp['carteira'], $camp['data'],
            $camp['linhas'], $camp['cash'], $camp['conquista'], $camp['atividade']
        ]);
    }
    echo "✓ f_campanhas populada\n";

    // 10. Popular f_detalhes
    echo "Populando f_detalhes...\n";
    $stmtDetalhes = $pdo->prepare("
        INSERT INTO f_detalhes (
            contrato_id, registro_id, segmento, segmento_id, diretoria_id, diretoria_nome,
            gerencia_regional_id, gerencia_regional_nome, agencia_id, agencia_nome,
            gerente_gestao_id, gerente_gestao_nome, gerente_id, gerente_nome,
            familia_id, familia_nome, id_indicador, ds_indicador, id_subindicador, subindicador,
            carteira, canal_venda, tipo_venda, modalidade_pagamento,
            data, competencia, valor_meta, valor_realizado, quantidade, peso, pontos, status_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $detalhes = [
        [
            'contrato_id' => 'CONT7378LIG001',
            'registro_id' => 'REAL_7378_LIG001_202510',
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria_id' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional_id' => '8684', 'gerencia_regional_nome' => 'SP Sul e Oeste',
            'agencia_id' => '7378', 'agencia_nome' => 'Faria Lima 1',
            'gerente_gestao_id' => 'GG8684', 'gerente_gestao_nome' => 'Marcos Peixoto',
            'gerente_id' => 'GE7378', 'gerente_nome' => 'Gerente 7378',
            'familia_id' => 'ligadas', 'familia_nome' => 'Ligadas',
            'id_indicador' => 'cartoes', 'ds_indicador' => 'Cartões',
            'id_subindicador' => 'SUB006', 'subindicador' => 'Cartão de Crédito Emissão Classic',
            'carteira' => 'Carteira Empresas', 'canal_venda' => 'Híbrido', 'tipo_venda' => 'Campanha',
            'modalidade_pagamento' => 'Parcelado',
            'data' => '2025-10-09', 'competencia' => '2025-10-01',
            'valor_meta' => 95000, 'valor_realizado' => 98250, 'quantidade' => 5,
            'peso' => 42, 'pontos' => 41, 'status_id' => '01'
        ],
        [
            'contrato_id' => 'CONT3336CRE001',
            'registro_id' => 'REAL_3336_CRE001_202506',
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria_id' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional_id' => '8487', 'gerencia_regional_nome' => 'Nordeste',
            'agencia_id' => '3336', 'agencia_nome' => 'Salvador',
            'gerente_gestao_id' => 'GG8487', 'gerente_gestao_nome' => 'Rafael Carvalho',
            'gerente_id' => 'GE3336', 'gerente_nome' => 'Gerente 3336',
            'familia_id' => 'credito', 'familia_nome' => 'Crédito',
            'id_indicador' => 'prod_credito_pj', 'ds_indicador' => 'Produção de Crédito PJ',
            'id_subindicador' => 'SUB005', 'subindicador' => 'Linha PJ',
            'carteira' => 'Carteira Empresas', 'canal_venda' => 'Digital', 'tipo_venda' => 'Renovação',
            'modalidade_pagamento' => 'À vista',
            'data' => '2025-06-18', 'competencia' => '2025-06-01',
            'valor_meta' => 82000, 'valor_realizado' => 83500, 'quantidade' => 4,
            'peso' => 35, 'pontos' => 34.5, 'status_id' => '01'
        ],
        [
            'contrato_id' => 'CONT1697CAP001',
            'registro_id' => 'REAL_1697_CAP001_202501',
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria_id' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional_id' => '8485', 'gerencia_regional_nome' => 'SUL',
            'agencia_id' => '1697', 'agencia_nome' => 'Itajaí - SC',
            'gerente_gestao_id' => 'GG8485', 'gerente_gestao_nome' => 'Aline Siqueira',
            'gerente_id' => 'GE1697', 'gerente_nome' => 'Gerente 1697',
            'familia_id' => 'captacao', 'familia_nome' => 'Captação',
            'id_indicador' => 'captacao_bruta', 'ds_indicador' => 'Captação Bruta',
            'id_subindicador' => 'SUB001', 'subindicador' => 'CDB e Isentos',
            'carteira' => 'Carteira Empresas', 'canal_venda' => 'Presencial', 'tipo_venda' => 'Venda ativa',
            'modalidade_pagamento' => 'Parcelado',
            'data' => '2025-01-15', 'competencia' => '2025-01-01',
            'valor_meta' => 60000, 'valor_realizado' => 64500, 'quantidade' => 6,
            'peso' => 40, 'pontos' => 38, 'status_id' => '01'
        ],
    ];

    foreach ($detalhes as $det) {
        $stmtDetalhes->execute([
            $det['contrato_id'], $det['registro_id'], $det['segmento'], $det['segmento_id'], $det['diretoria_id'], $det['diretoria_nome'],
            $det['gerencia_regional_id'], $det['gerencia_regional_nome'], $det['agencia_id'], $det['agencia_nome'],
            $det['gerente_gestao_id'], $det['gerente_gestao_nome'], $det['gerente_id'], $det['gerente_nome'],
            $det['familia_id'], $det['familia_nome'], $det['id_indicador'], $det['ds_indicador'], $det['id_subindicador'], $det['subindicador'],
            $det['carteira'], $det['canal_venda'], $det['tipo_venda'], $det['modalidade_pagamento'],
            $det['data'], $det['competencia'], $det['valor_meta'], $det['valor_realizado'],
            $det['quantidade'], $det['peso'], $det['pontos'], $det['status_id']
        ]);
    }
    echo "✓ f_detalhes populada\n";

    // 11. Popular f_historico_ranking_pobj
    echo "Populando f_historico_ranking_pobj...\n";
    $stmtHistorico = $pdo->prepare("
        INSERT INTO f_historico_ranking_pobj (
            `database`, nivel, ano,
            segmento, segmento_id, diretoria, diretoria_nome,
            gerencia_regional, gerencia_regional_nome, agencia, agencia_nome,
            gerente_gestao, gerente_gestao_nome, gerente, gerente_nome,
            participantes, `rank`, pontos, realizado, meta
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            segmento = VALUES(segmento),
            diretoria_nome = VALUES(diretoria_nome),
            gerencia_regional_nome = VALUES(gerencia_regional_nome),
            agencia_nome = VALUES(agencia_nome),
            gerente_gestao_nome = VALUES(gerente_gestao_nome),
            gerente_nome = VALUES(gerente_nome),
            participantes = VALUES(participantes),
            `rank` = VALUES(`rank`),
            pontos = VALUES(pontos),
            realizado = VALUES(realizado),
            meta = VALUES(meta)
    ");

    $historicos = [
        [
            'database' => '2025-10-11', 'nivel' => 'Agência', 'ano' => 2025,
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional' => '8684', 'gerencia_regional_nome' => 'SP Sul e Oeste',
            'agencia' => '7378', 'agencia_nome' => 'Faria Lima 1',
            'gerente_gestao' => 'GG8684', 'gerente_gestao_nome' => 'Marcos Peixoto',
            'gerente' => 'GE7378', 'gerente_nome' => 'Gerente 7378',
            'participantes' => 24, 'rank' => 3, 'pontos' => 88.9,
            'realizado' => 692000, 'meta' => 701500
        ],
        [
            'database' => '2025-07-31', 'nivel' => 'Agência', 'ano' => 2025,
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional' => '8684', 'gerencia_regional_nome' => 'SP Sul e Oeste',
            'agencia' => '7378', 'agencia_nome' => 'Faria Lima 1',
            'gerente_gestao' => 'GG8684', 'gerente_gestao_nome' => 'Marcos Peixoto',
            'gerente' => 'GE7378', 'gerente_nome' => 'Gerente 7378',
            'participantes' => 22, 'rank' => 1, 'pontos' => 97.5,
            'realizado' => 512000, 'meta' => 498500
        ],
        [
            'database' => '2025-04-30', 'nivel' => 'Agência', 'ano' => 2025,
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional' => '8487', 'gerencia_regional_nome' => 'Nordeste',
            'agencia' => '3336', 'agencia_nome' => 'Salvador',
            'gerente_gestao' => 'GG8487', 'gerente_gestao_nome' => 'Rafael Carvalho',
            'gerente' => 'GE3336', 'gerente_nome' => 'Gerente 3336',
            'participantes' => 18, 'rank' => 2, 'pontos' => 91.2,
            'realizado' => 362500, 'meta' => 348000
        ],
        [
            'database' => '2025-01-31', 'nivel' => 'Agência', 'ano' => 2025,
            'segmento' => 'Empresas', 'segmento_id' => '1',
            'diretoria' => '8607', 'diretoria_nome' => 'Empresas',
            'gerencia_regional' => '8485', 'gerencia_regional_nome' => 'SUL',
            'agencia' => '1697', 'agencia_nome' => 'Itajaí - SC',
            'gerente_gestao' => 'GG8485', 'gerente_gestao_nome' => 'Aline Siqueira',
            'gerente' => 'GE1697', 'gerente_nome' => 'Gerente 1697',
            'participantes' => 18, 'rank' => 1, 'pontos' => 96.4,
            'realizado' => 185000, 'meta' => 172000
        ],
    ];

    foreach ($historicos as $hist) {
        $stmtHistorico->execute([
            $hist['database'], $hist['nivel'], $hist['ano'],
            $hist['segmento'], $hist['segmento_id'], $hist['diretoria'], $hist['diretoria_nome'],
            $hist['gerencia_regional'], $hist['gerencia_regional_nome'], $hist['agencia'], $hist['agencia_nome'],
            $hist['gerente_gestao'], $hist['gerente_gestao_nome'], $hist['gerente'], $hist['gerente_nome'],
            $hist['participantes'], $hist['rank'], $hist['pontos'], $hist['realizado'], $hist['meta']
        ]);
    }
    echo "✓ f_historico_ranking_pobj populada\n";

    // 12. Popular f_leads_propensos
    echo "Populando f_leads_propensos...\n";
    $stmtLeads = $pdo->prepare("
        INSERT INTO f_leads_propensos (
            `database`, nome_empresa, cnae,
            segmento_cliente, segmento_cliente_id, produto_propenso, familia_produto_propenso,
            secao_produto_propenso, id_indicador, id_subindicador,
            data_contato, comentario, responsavel_contato,
            diretoria_cliente, diretoria_cliente_id, regional_cliente, regional_cliente_id,
            agencia_cliente, agencia_cliente_id, gerente_gestao_cliente, gerente_gestao_cliente_id,
            gerente_cliente, gerente_cliente_id, credito_pre_aprovado, origem_lead
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            cnae = VALUES(cnae),
            segmento_cliente = VALUES(segmento_cliente),
            produto_propenso = VALUES(produto_propenso),
            familia_produto_propenso = VALUES(familia_produto_propenso),
            secao_produto_propenso = VALUES(secao_produto_propenso),
            id_indicador = VALUES(id_indicador),
            id_subindicador = VALUES(id_subindicador),
            data_contato = VALUES(data_contato),
            comentario = VALUES(comentario),
            responsavel_contato = VALUES(responsavel_contato),
            credito_pre_aprovado = VALUES(credito_pre_aprovado),
            origem_lead = VALUES(origem_lead)
    ");

    $leads = [
        [
            'database' => '2025-10-04', 'nome_empresa' => 'Orion Engenharia', 'cnae' => '7112-0/00',
            'segmento_cliente' => 'Empresas', 'segmento_cliente_id' => 'SEG_EMP',
            'produto_propenso' => 'Cartões Corporativos', 'familia_produto_propenso' => 'Cartões',
            'secao_produto_propenso' => 'Serviços financeiros', 'id_indicador' => 'cartoes', 'id_subindicador' => 'SUB006',
            'data_contato' => '2025-10-08', 'comentario' => 'Equipe interessada em programa de milhas',
            'responsavel_contato' => 'Ana Especialista',
            'diretoria_cliente' => 'Empresas', 'diretoria_cliente_id' => '8607',
            'regional_cliente' => 'SP Sul e Oeste', 'regional_cliente_id' => '8684',
            'agencia_cliente' => 'Faria Lima 1', 'agencia_cliente_id' => '7378',
            'gerente_gestao_cliente' => 'Marcos Peixoto', 'gerente_gestao_cliente_id' => 'GG8684',
            'gerente_cliente' => 'Gerente 7378', 'gerente_cliente_id' => 'GE7378',
            'credito_pre_aprovado' => 280000.00, 'origem_lead' => 'Indicação parceiro'
        ],
        [
            'database' => '2025-09-25', 'nome_empresa' => 'Delta Logística', 'cnae' => '4930-2/01',
            'segmento_cliente' => 'Empresas', 'segmento_cliente_id' => 'SEG_EMP',
            'produto_propenso' => 'Capital de Giro', 'familia_produto_propenso' => 'Crédito',
            'secao_produto_propenso' => 'Linhas corporativas', 'id_indicador' => 'prod_credito_pj', 'id_subindicador' => 'SUB005',
            'data_contato' => '2025-09-28', 'comentario' => 'Solicitou proposta para expansão regional',
            'responsavel_contato' => 'Bruno Consultor',
            'diretoria_cliente' => 'Empresas', 'diretoria_cliente_id' => '8607',
            'regional_cliente' => 'SUL', 'regional_cliente_id' => '8485',
            'agencia_cliente' => 'Itajaí - SC', 'agencia_cliente_id' => '1697',
            'gerente_gestao_cliente' => 'Aline Siqueira', 'gerente_gestao_cliente_id' => 'GG8485',
            'gerente_cliente' => 'Gerente 1697', 'gerente_cliente_id' => 'GE1697',
            'credito_pre_aprovado' => 350000.00, 'origem_lead' => 'Feira de negócios'
        ],
    ];

    foreach ($leads as $lead) {
        $stmtLeads->execute([
            $lead['database'], $lead['nome_empresa'], $lead['cnae'],
            $lead['segmento_cliente'], $lead['segmento_cliente_id'], $lead['produto_propenso'], $lead['familia_produto_propenso'],
            $lead['secao_produto_propenso'], $lead['id_indicador'], $lead['id_subindicador'],
            $lead['data_contato'], $lead['comentario'], $lead['responsavel_contato'],
            $lead['diretoria_cliente'], $lead['diretoria_cliente_id'], $lead['regional_cliente'], $lead['regional_cliente_id'],
            $lead['agencia_cliente'], $lead['agencia_cliente_id'], $lead['gerente_gestao_cliente'], $lead['gerente_gestao_cliente_id'],
            $lead['gerente_cliente'], $lead['gerente_cliente_id'], $lead['credito_pre_aprovado'], $lead['origem_lead']
        ]);
    }
    echo "✓ f_leads_propensos populada\n";

    $pdo->commit();
    echo "\n✅ População concluída com sucesso!\n";
    echo "Todos os dados foram inseridos no banco de dados.\n";

} catch (\Exception $e) {
    $pdo->rollBack();
    echo "\n❌ Erro ao popular banco de dados: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}

