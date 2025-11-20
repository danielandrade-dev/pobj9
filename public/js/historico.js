// BEGIN historico.js
/* =========================================================
   POBJ • historico.js  —  API e processamento de dados de histórico
   ========================================================= */

/* ===== Variável global relacionada a histórico ===== */
var FACT_HISTORICO_RANKING_POBJ = [];

// Disponibiliza globalmente se window estiver disponível
if (typeof window !== "undefined") {
  window.FACT_HISTORICO_RANKING_POBJ = FACT_HISTORICO_RANKING_POBJ;
}

/* ===== Função para normalizar linhas de histórico ===== */
function normalizarLinhasHistoricoRankingPobj(rows){
  if (!Array.isArray(rows)) return [];

  const mapNivel = (value) => {
    const simple = simplificarTexto(value);
    if (simple === "diretoria") return "diretoria";
    if (simple === "gerencia" || simple === "gerenciaregional") return "gerencia";
    if (simple === "agencia") return "agencia";
    if (simple === "gerente") return "gerente";
    return "";
  };

  return rows.map(raw => {
    const nivel = mapNivel(lerCelula(raw, ["nivel", "Nivel", "Nível", "level"]));
    if (!nivel) return null;

    const anoText = lerCelula(raw, ["ano", "Ano", "year", "Year"]);
    const anoNum = Number(anoText);
    const ano = Number.isFinite(anoNum) ? anoNum : null;
    const database = typeof converterDataISO === "function" 
      ? converterDataISO(lerCelula(raw, ["database", "competencia", "Competencia", "data", "Data"]))
      : "";

    const segmento = lerCelula(raw, ["segmento", "Segmento"]);
    const segmentoId = lerCelula(raw, ["segmentoId", "SegmentoId", "segmento_id", "Id Segmento"]);
    const diretoria = lerCelula(raw, ["diretoria", "Diretoria", "diretoriaId", "DiretoriaId", "ID Diretoria"]);
    const diretoriaNome = lerCelula(raw, ["diretoriaNome", "DiretoriaNome", "Diretoria Nome", "diretoria_nome"]);
    const gerenciaRegional = lerCelula(raw, ["gerenciaRegional", "GerenciaRegional", "gerencia", "Gerencia", "Gerencia ID"]);
    const gerenciaNome = lerCelula(raw, ["gerenciaNome", "GerenciaNome", "Regional Nome", "regionalNome"]);
    const agencia = lerCelula(raw, ["agencia", "Agencia", "agenciaId", "AgenciaId"]);
    const agenciaNome = lerCelula(raw, ["agenciaNome", "AgenciaNome", "Agencia Nome"]);
    const agenciaCodigo = lerCelula(raw, ["agenciaCodigo", "AgenciaCodigo", "Codigo Agencia", "Agencia Codigo"]);
    const gerenteGestao = lerCelula(raw, ["gerenteGestao", "GerenteGestao", "gerenteGestaoId", "GerenteGestaoId", "gerente_gestao_id"]);
    const gerenteGestaoNome = lerCelula(raw, [
      "gerenteGestaoNome",
      "GerenteGestaoNome",
      "Gerente Gestao Nome",
      "Gerente de Gestao Nome",
      "Gerente de Gestão Nome",
      "gerente_gestao_nome"
    ]);
    const gerente = lerCelula(raw, ["gerente", "Gerente", "gerenteId", "GerenteId"]);
    const gerenteNome = lerCelula(raw, ["gerenteNome", "GerenteNome", "Gerente Nome"]);

    const participantesNum = Number(lerCelula(raw, ["participantes", "Participantes", "totalParticipantes"]));
    const participantes = Number.isFinite(participantesNum) && participantesNum > 0 ? participantesNum : null;

    const rankNum = Number(lerCelula(raw, ["rank", "Rank", "posicao", "posição", "classificacao"]));
    const rank = Number.isFinite(rankNum) && rankNum > 0 ? rankNum : null;

    const pontosNum = Number(lerCelula(raw, ["pontos", "Pontos", "pontuacao", "Pontuacao", "p_acum"]));
    const pontos = Number.isFinite(pontosNum) ? pontosNum : null;

    const realizadoNum = Number(lerCelula(raw, ["realizado", "Realizado", "real_acum", "Real_acum", "resultado"]));
    const metaNum = Number(lerCelula(raw, ["meta", "Meta", "meta_acum", "Meta_acum"]));

    return {
      nivel,
      ano,
      database: database || (ano ? `${ano}-12-31` : ""),
      segmento,
      segmentoId,
      diretoria,
      diretoriaId: diretoria || diretoriaNome,
      diretoriaNome: diretoriaNome || diretoria,
      gerenciaRegional,
      gerenciaId: gerenciaRegional || gerenciaNome,
      gerenciaNome: gerenciaNome || gerenciaRegional,
      agencia,
      agenciaId: agencia || agenciaCodigo || agenciaNome,
      agenciaNome: agenciaNome || agencia,
      agenciaCodigo: agenciaCodigo || agencia,
      gerenteGestao,
      gerenteGestaoId: gerenteGestao || gerenteGestaoNome,
      gerenteGestaoNome: gerenteGestaoNome || gerenteGestao,
      gerente,
      gerenteId: gerente || gerenteNome,
      gerenteNome: gerenteNome || gerente,
      participantes,
      rank,
      pontos,
      realizado: Number.isFinite(realizadoNum) ? realizadoNum : null,
      meta: Number.isFinite(metaNum) ? metaNum : null,
    };
  }).filter(Boolean);
}

/* ===== Função para carregar dados de histórico da API ===== */
async function loadHistoricoData(){
  try {
    const historico = await apiGet('/historico').catch(() => []);
    return Array.isArray(historico) ? historico : [];
  } catch (error) {
    console.error('Erro ao carregar dados de histórico:', error);
    return [];
  }
}

/* ===== Função para processar dados de histórico ===== */
function processHistoricoData(historicoRaw = []) {
  FACT_HISTORICO_RANKING_POBJ = normalizarLinhasHistoricoRankingPobj(Array.isArray(historicoRaw) ? historicoRaw : []);
  
  // Atualiza referência global
  if (typeof window !== "undefined") {
    window.FACT_HISTORICO_RANKING_POBJ = FACT_HISTORICO_RANKING_POBJ;
  }
  
  return FACT_HISTORICO_RANKING_POBJ;
}

// END historico.js

