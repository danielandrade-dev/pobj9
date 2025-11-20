// BEGIN detalhes.js
/* =========================================================
   POBJ • detalhes.js  —  API e processamento de dados de detalhes
   ========================================================= */

/* ===== Variáveis globais relacionadas a detalhes ===== */
var FACT_DETALHES = [];
var DETAIL_BY_REGISTRO = new Map();
var DETAIL_CONTRACT_IDS = new Set();

// Disponibiliza globalmente se window estiver disponível
if (typeof window !== "undefined") {
  window.FACT_DETALHES = FACT_DETALHES;
  window.DETAIL_BY_REGISTRO = DETAIL_BY_REGISTRO;
  window.DETAIL_CONTRACT_IDS = DETAIL_CONTRACT_IDS;
}

/* ===== Função para normalizar linhas de detalhes ===== */
function normalizarLinhasFatoDetalhes(rows){
  if (!Array.isArray(rows)) return [];

  return rows.map(raw => {
    const contratoId = limparTexto(lerCelula(raw, ["Contrato ID", "contrato_id", "Contrato", "Id Contrato", "ID Contrato"]));
    const registroId = limparTexto(lerCelula(raw, ["Registro ID", "registro_id", "Registro", "Id Registro", "ID Registro"]));
    if (!contratoId || !registroId) return null;

    const segmentoId = limparTexto(lerCelula(raw, ["Segmento ID", "segmento_id", "segmentoId"]));
    const segmento = limparTexto(lerCelula(raw, ["Segmento", "segmento"])) || segmentoId;
    const diretoriaId = limparTexto(lerCelula(raw, ["Diretoria ID", "diretoria_id", "diretoriaId"]));
    const diretoriaNome = limparTexto(lerCelula(raw, ["Diretoria Nome", "Diretoria Regional", "diretoria_nome"])) || diretoriaId;
    const gerenciaId = limparTexto(lerCelula(raw, ["Gerencia Regional ID", "Gerencia ID", "gerencia_regional_id", "gerenciaId", "regional_id"]));
    const gerenciaNome = limparTexto(lerCelula(raw, ["Gerencia Regional Nome", "Regional Nome", "gerencia_regional_nome", "gerenciaNome"])) || gerenciaId;
    const agenciaId = limparTexto(lerCelula(raw, ["Agencia ID", "Agência ID", "agencia_id", "agenciaId"]));
    const agenciaNome = limparTexto(lerCelula(raw, ["Agencia Nome", "Agência Nome", "agencia_nome"])) || agenciaId;
    const agenciaCodigo = limparTexto(lerCelula(raw, ["Agencia Codigo", "Agência Codigo", "Codigo Agencia", "agencia_codigo"]))
      || agenciaId
      || agenciaNome;
    let gerenteGestaoId = limparTexto(lerCelula(raw, ["Gerente Gestao ID", "gerente_gestao_id", "GerenteGestaoId"]));
    let gerenteGestaoNome = limparTexto(lerCelula(raw, ["Gerente Gestao Nome", "Gerente de Gestao", "Gerente Gestao", "gerente_gestao_nome"]));
    let gerenteId = limparTexto(lerCelula(raw, ["Gerente ID", "gerente_id", "GerenteId"]));
    let gerenteNome = limparTexto(lerCelula(raw, ["Gerente Nome", "Gerente", "gerente_nome", "Gerente Geral", "Gerente geral"])) || gerenteId;

    if (!gerenteGestaoId) {
      if (typeof deriveGerenteGestaoIdFromAgency === "function") {
        const derivedGg = deriveGerenteGestaoIdFromAgency(agenciaId || agenciaCodigo || agenciaNome);
        if (derivedGg) {
          gerenteGestaoId = derivedGg;
        }
      }
    }

    if (!gerenteGestaoNome && gerenteGestaoId) {
      if (typeof getGerenteGestaoEntry === "function") {
        const entry = getGerenteGestaoEntry(gerenteGestaoId);
        if (entry) {
          gerenteGestaoNome = limparTexto(entry.nome) || (typeof extractNameFromLabel === "function" ? extractNameFromLabel(entry.label) : "") || gerenteGestaoId;
        }
      }
    }

    if (gerenteGestaoNome && gerenteGestaoNome.includes(" - ")) {
      gerenteGestaoNome = typeof extractNameFromLabel === "function" ? extractNameFromLabel(gerenteGestaoNome) : gerenteGestaoNome;
    }

    if (!gerenteNome && gerenteId) {
      if (typeof getGerenteEntry === "function") {
        const entry = getGerenteEntry(gerenteId);
        if (entry) {
          gerenteNome = limparTexto(entry.nome) || (typeof extractNameFromLabel === "function" ? extractNameFromLabel(entry.label) : "") || gerenteId;
        }
      }
    }

    if (gerenteNome && gerenteNome.includes(" - ")) {
      gerenteNome = typeof extractNameFromLabel === "function" ? extractNameFromLabel(gerenteNome) : gerenteNome;
    }

    let familiaId = limparTexto(lerCelula(raw, ["Familia ID", "familia_id", "Familia"]));
    let familiaNome = limparTexto(lerCelula(raw, ["Familia Nome", "familia_nome", "Família Nome", "Familia"])) || familiaId;

    let indicadorId = limparTexto(lerCelula(raw, ["ID Indicador", "Indicador ID", "id_indicador", "Indicador"]));
    let indicadorNome = limparTexto(lerCelula(raw, ["Indicador Nome", "ds_indicador", "Indicador"])) || indicadorId;

    let subId = limparTexto(lerCelula(raw, ["Subindicador ID", "id_subindicador", "Sub Produto ID", "Subproduto ID", "Subproduto"]));
    let subNome = limparTexto(lerCelula(raw, ["Subindicador Nome", "subindicador", "Subproduto", "Sub Produto"])) || subId;

    const carteira = limparTexto(lerCelula(raw, ["Carteira", "carteira"]));
    const canalVenda = limparTexto(lerCelula(raw, ["Canal Venda", "Canal", "canal_venda"]));
    const tipoVenda = limparTexto(lerCelula(raw, ["Tipo Venda", "tipo_venda", "Tipo"]));
    const modalidade = limparTexto(lerCelula(raw, ["Modalidade Pagamento", "modalidade_pagamento", "Modalidade"]));

    let data = typeof converterDataISO === "function" ? converterDataISO(lerCelula(raw, ["Data", "Data Movimento", "data"])) : "";
    let competencia = typeof converterDataISO === "function" ? converterDataISO(lerCelula(raw, ["Competencia", "competencia", "Competência"])) : "";
    if (!competencia && data) competencia = `${data.slice(0, 7)}-01`;
    if (!data && competencia) data = competencia;

    const dataVencimento = typeof converterDataISO === "function" ? converterDataISO(lerCelula(raw, ["Data Vencimento", "data_vencimento"])) : "";
    const dataCancelamento = typeof converterDataISO === "function" ? converterDataISO(lerCelula(raw, ["Data Cancelamento", "data_cancelamento"])) : "";
    const motivoCancelamento = limparTexto(lerCelula(raw, ["Motivo Cancelamento", "motivo_cancelamento", "Motivo"]));

    const valorMeta = toNumber(lerCelula(raw, ["Valor Meta", "Meta", "meta", "meta_mensal", "meta_contrato", "metaValor"]));
    const valorReal = toNumber(lerCelula(raw, ["Valor Realizado", "Realizado", "realizado", "real_mensal", "valor_realizado", "realizadoValor"]));
    const quantidade = toNumber(lerCelula(raw, ["Quantidade", "Qtd", "quantidade", "Quantidade Contrato"]));
    const peso = toNumber(lerCelula(raw, ["Peso", "peso", "pontos_meta", "Pontos Meta"]));
    const pontos = toNumber(lerCelula(raw, ["Pontos", "pontos", "pontos_cumpridos", "Pontos Cumpridos"]));
    const statusId = limparTexto(lerCelula(raw, ["Status ID", "status_id", "Status"]));

    const scenarioHint = typeof getSegmentScenarioFromValue === "function" 
      ? (getSegmentScenarioFromValue(segmento) || getSegmentScenarioFromValue(segmentoId) || "")
      : "";
    const indicadorRes = typeof resolveIndicatorFromDimension === "function"
      ? resolveIndicatorFromDimension([indicadorId, indicadorNome], scenarioHint)
      : null;
    if (indicadorRes) {
      if (indicadorRes.indicadorId) indicadorId = indicadorRes.indicadorId;
      if (indicadorRes.indicadorNome) indicadorNome = indicadorRes.indicadorNome;
      if (indicadorRes.familiaId) familiaId = indicadorRes.familiaId;
      if (indicadorRes.familiaNome) familiaNome = indicadorRes.familiaNome;
    }

    const subRes = typeof resolveSubIndicatorFromDimension === "function"
      ? resolveSubIndicatorFromDimension([subId, subNome], indicadorRes, scenarioHint)
      : null;
    if (subRes) {
      if (subRes.subId) subId = subRes.subId;
      if (subRes.subNome) subNome = subRes.subNome;
      if (subRes.familiaId && !familiaId) familiaId = subRes.familiaId;
      if (subRes.familiaNome && !familiaNome) familiaNome = subRes.familiaNome;
    }

    const detail = {
      id: contratoId,
      registroId,
      segmento,
      segmentoId,
      diretoria: diretoriaId,
      diretoriaId,
      diretoriaNome,
      gerenciaRegional: gerenciaId,
      gerenciaId,
      gerenciaNome,
      regional: gerenciaNome,
      agencia: agenciaId || agenciaCodigo || agenciaNome,
      agenciaId: agenciaId || agenciaCodigo || agenciaNome,
      agenciaNome: agenciaNome || agenciaId || agenciaCodigo,
      agenciaCodigo: agenciaCodigo || agenciaId || agenciaNome,
      gerenteGestao: gerenteGestaoId,
      gerenteGestaoId,
      gerenteGestaoNome: gerenteGestaoNome || gerenteGestaoId,
      gerente: gerenteId,
      gerenteId,
      gerenteNome,
      familiaId,
      familiaNome,
      carteira,
      canalVenda,
      tipoVenda,
      modalidadePagamento: modalidade,
      data,
      competencia,
      realizado: Number.isFinite(valorReal) ? valorReal : 0,
      meta: Number.isFinite(valorMeta) ? valorMeta : 0,
      qtd: Number.isFinite(quantidade) && quantidade > 0 ? quantidade : 1,
      peso: Number.isFinite(peso) ? peso : 0,
      pontos: Number.isFinite(pontos) ? pontos : undefined,
      dataVencimento,
      dataCancelamento,
      motivoCancelamento,
      statusId,
    };

    // Usa resolveMapLabel se disponível, caso contrário usa valores diretos
    if (typeof resolveMapLabel === "function") {
      const segMapRef = typeof segMap !== "undefined" ? segMap : null;
      const dirMapRef = typeof dirMap !== "undefined" ? dirMap : null;
      const regMapRef = typeof regMap !== "undefined" ? regMap : null;
      const agMapRef = typeof agMap !== "undefined" ? agMap : null;
      
      detail.segmentoLabel = resolveMapLabel(segMapRef, segmentoId, segmento, segmentoId);
      detail.diretoriaLabel = resolveMapLabel(dirMapRef, diretoriaId, diretoriaNome, diretoriaId);
      detail.gerenciaLabel = resolveMapLabel(regMapRef, gerenciaId, gerenciaNome, gerenciaId);
      detail.agenciaLabel = resolveMapLabel(agMapRef, agenciaId, agenciaNome, agenciaId);
    } else {
      detail.segmentoLabel = segmento;
      detail.diretoriaLabel = diretoriaNome;
      detail.gerenciaLabel = gerenciaNome;
      detail.agenciaLabel = agenciaNome;
    }
    
    if (typeof labelGerenteGestao === "function") {
      detail.gerenteGestaoLabel = labelGerenteGestao(gerenteGestaoId, gerenteGestaoNome);
    } else {
      detail.gerenteGestaoLabel = gerenteGestaoNome || gerenteGestaoId;
    }
    
    if (typeof labelGerente === "function") {
      detail.gerenteLabel = labelGerente(gerenteId, gerenteNome);
    } else {
      detail.gerenteLabel = gerenteNome || gerenteId;
    }

    if (detail.segmentoLabel) detail.segmento = detail.segmentoLabel;
    if (detail.diretoriaLabel) detail.diretoriaNome = typeof extractNameFromLabel === "function" ? extractNameFromLabel(detail.diretoriaLabel) || detail.diretoriaNome : detail.diretoriaNome;
    if (detail.gerenciaLabel) detail.gerenciaNome = typeof extractNameFromLabel === "function" ? extractNameFromLabel(detail.gerenciaLabel) || detail.gerenciaNome : detail.gerenciaNome;
    if (detail.agenciaLabel) detail.agenciaNome = typeof extractNameFromLabel === "function" ? extractNameFromLabel(detail.agenciaLabel) || detail.agenciaNome : detail.agenciaNome;
    if (detail.gerenteGestaoLabel) detail.gerenteGestaoNome = typeof extractNameFromLabel === "function" ? extractNameFromLabel(detail.gerenteGestaoLabel) || detail.gerenteGestaoNome : detail.gerenteGestaoNome;
    if (detail.gerenteLabel) detail.gerenteNome = typeof extractNameFromLabel === "function" ? extractNameFromLabel(detail.gerenteLabel) || detail.gerenteNome : detail.gerenteNome;

    if (typeof aplicarIndicadorAliases === "function") {
      aplicarIndicadorAliases(detail, indicadorId, indicadorNome);
    }
    if (subId) {
      detail.subproduto = subNome || subId;
      detail.subIndicadorId = subId;
      detail.subIndicadorNome = subNome || subId;
    }
    if (!detail.familiaId) detail.familiaId = familiaId;
    if (!detail.familiaNome) detail.familiaNome = familiaNome || familiaId;
    detail.prodOrSub = detail.subproduto || detail.produtoNome || detail.produtoId;
    detail.ating = detail.meta ? (detail.realizado / detail.meta) : 0;
    if (detail.pontos === undefined) {
      const pontosCalc = Math.max(0, detail.peso || 0) * (detail.ating || 0);
      detail.pontos = Number.isFinite(pontosCalc) ? pontosCalc : 0;
    }

    return detail;
  }).filter(Boolean);
}

/* ===== Função para carregar dados de detalhes da API ===== */
async function loadDetalhesData(){
  try {
    const detalhes = await apiGet('/detalhes').catch(() => []);
    return Array.isArray(detalhes) ? detalhes : [];
  } catch (error) {
    console.error('Erro ao carregar dados de detalhes:', error);
    return [];
  }
}

/* ===== Função para processar dados de detalhes ===== */
function processDetalhesData(detalhesRaw = []) {
  FACT_DETALHES = normalizarLinhasFatoDetalhes(Array.isArray(detalhesRaw) ? detalhesRaw : []);
  
  // Atualiza referências globais
  if (typeof window !== "undefined") {
    window.FACT_DETALHES = FACT_DETALHES;
  }
  
  // Aplica fallback de hierarquia se a função estiver disponível
  if (typeof applyHierarchyFallback === "function") {
    applyHierarchyFallback(FACT_DETALHES);
  }
  
  // Constrói índices de detalhes
  DETAIL_BY_REGISTRO = new Map();
  DETAIL_CONTRACT_IDS = new Set();
  FACT_DETALHES.forEach(row => {
    if (!row) return;
    const registroKey = limparTexto(row.registroId);
    if (registroKey) {
      const bucket = DETAIL_BY_REGISTRO.get(registroKey) || [];
      bucket.push({ ...row });
      DETAIL_BY_REGISTRO.set(registroKey, bucket);
    }
    const contratoKey = limparTexto(row.id);
    if (contratoKey) DETAIL_CONTRACT_IDS.add(contratoKey);
  });
  
  // Atualiza referências globais
  if (typeof window !== "undefined") {
    window.DETAIL_BY_REGISTRO = DETAIL_BY_REGISTRO;
    window.DETAIL_CONTRACT_IDS = DETAIL_CONTRACT_IDS;
  }
  
  return FACT_DETALHES;
}

// END detalhes.js

