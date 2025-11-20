// BEGIN api-leads.js
/* =========================================================
   POBJ • api-leads.js  —  API de dados de leads
   ========================================================= */

/* ===== Função para carregar dados de leads da API ===== */
async function loadLeadsData(){
  try {
    const leads = await apiGet('/leads').catch(() => []);
    return Array.isArray(leads) ? leads : [];
  } catch (error) {
    console.error('Erro ao carregar dados de leads:', error);
    return [];
  }
}

/* ===== Função para processar dados de leads ===== */
function processLeadsData(leadsRaw = []) {
  // O processamento é feito pela função ingestOpportunityLeadRows que está em leads.js
  // Esta função apenas prepara os dados para serem processados
  const leadsArray = Array.isArray(leadsRaw) ? leadsRaw : [];
  
  // Atualiza OPPORTUNITY_LEADS_RAW se estiver disponível (definido em leads.js)
  if (typeof window !== "undefined" && typeof window.OPPORTUNITY_LEADS_RAW !== "undefined") {
    window.OPPORTUNITY_LEADS_RAW = leadsArray;
  } else if (typeof OPPORTUNITY_LEADS_RAW !== "undefined") {
    OPPORTUNITY_LEADS_RAW = leadsArray;
  }
  
  // Chama a função de ingestão se estiver disponível (definida em leads.js)
  if (typeof ingestOpportunityLeadRows === "function") {
    ingestOpportunityLeadRows(leadsArray);
  } else if (typeof window !== "undefined" && typeof window.ingestOpportunityLeadRows === "function") {
    window.ingestOpportunityLeadRows(leadsArray);
  }
  
  return leadsArray;
}

// END api-leads.js

