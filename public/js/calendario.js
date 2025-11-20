// BEGIN calendario.js
/* =========================================================
   POBJ • calendario.js  —  API e processamento de dados de calendário
   ========================================================= */

/* ===== Variável de calendário ===== */
var DIM_CALENDARIO = [];

// Disponibiliza globalmente se window estiver disponível
if (typeof window !== "undefined") {
  window.DIM_CALENDARIO = DIM_CALENDARIO;
}

/* ===== Função para normalizar linhas de calendário ===== */
function normalizarLinhasCalendario(rows){
  return rows.map(raw => {
    const data = converterDataISO(lerCelula(raw, ["Data"]));
    if (!data) return null;
    const competencia = converterDataISO(lerCelula(raw, ["Competencia", "Competência"])) || `${data.slice(0, 7)}-01`;
    const ano = lerCelula(raw, ["Ano"]) || data.slice(0, 4);
    const mes = lerCelula(raw, ["Mes", "Mês"]) || data.slice(5, 7);
    const mesNome = lerCelula(raw, ["Mes Nome", "Mês Nome"]);
    const dia = lerCelula(raw, ["Dia"]) || data.slice(8, 10);
    const diaSemana = lerCelula(raw, ["Dia da Semana"]);
    const semana = lerCelula(raw, ["Semana"]);
    const trimestre = lerCelula(raw, ["Trimestre"]);
    const semestre = lerCelula(raw, ["Semestre"]);
    const ehDiaUtil = converterBooleano(lerCelula(raw, ["Eh Dia Util", "É Dia Útil", "Dia Util"]), false) ? 1 : 0;
    const mesAnoCurto = construirEtiquetaMesAno(ano, mes, mesNome);
    return { data, competencia, ano, mes, mesNome, mesAnoCurto, dia, diaSemana, semana, trimestre, semestre, ehDiaUtil };
  }).filter(Boolean).sort((a, b) => (a.data || "").localeCompare(b.data || ""));
}

/* ===== Função para carregar dados de calendário da API ===== */
async function loadCalendarioData(){
  try {
    const calendario = await apiGet('/calendario').catch(() => []);
    return Array.isArray(calendario) ? calendario : [];
  } catch (error) {
    console.error('Erro ao carregar dados de calendário:', error);
    return [];
  }
}

/* ===== Função para processar dados de calendário ===== */
function processCalendarioData(calendarioRaw = []) {
  DIM_CALENDARIO = normalizarLinhasCalendario(Array.isArray(calendarioRaw) ? calendarioRaw : []);
  
  // Atualiza referência global
  if (typeof window !== "undefined") {
    window.DIM_CALENDARIO = DIM_CALENDARIO;
  }
  
  return DIM_CALENDARIO;
}

// END calendario.js

