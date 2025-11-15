<?php

require __DIR__ . '/../vendor/autoload.php';

use Pobj\Api\Database\DoctrineManager;

$em = DoctrineManager::getEntityManager();
$conn = $em->getConnection();

echo "Populando dados vazios...\n";

// 1. Atualizar d_unidade com gerentes e gerentes de gestão
echo "Atualizando d_unidade com gerentes...\n";
$conn->executeStatement("
    UPDATE d_unidade 
    SET gerente_gestao_id = CONCAT('GG', regional_id),
        gerente_gestao = CONCAT('Gerente Gestão ', regional_label),
        gerente_id = CONCAT('GE', agencia_id),
        gerente = CONCAT('Gerente ', agencia_label)
    WHERE gerente_gestao_id IS NULL OR gerente_gestao_id = ''
");

// 2. Inserir dados em f_variavel baseado nos funcionais existentes
echo "Inserindo dados em f_variavel...\n";
$funcionais = $conn->executeQuery("SELECT funcional FROM d_estrutura LIMIT 5")->fetchFirstColumn();

if (empty($funcionais)) {
    // Se não houver funcionais, criar alguns de exemplo
    $funcionais = ['i010001', 'i020212', 'i020213', 'i030001', 'i040001'];
}

foreach ($funcionais as $index => $funcional) {
    $meta = (1000 + ($index * 100));
    $variavel = $meta * (0.8 + (rand(0, 40) / 100)); // 80% a 120% da meta
    
    $conn->executeStatement("
        INSERT INTO f_variavel (funcional, meta, variavel, dt_atualizacao)
        VALUES (?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE
            meta = VALUES(meta),
            variavel = VALUES(variavel),
            dt_atualizacao = NOW()
    ", [$funcional, $meta, $variavel]);
}

echo "Dados populados com sucesso!\n";
echo "Total gerentes_gestao: " . $conn->executeQuery("SELECT COUNT(DISTINCT gerente_gestao_id) FROM d_unidade WHERE gerente_gestao_id IS NOT NULL AND gerente_gestao_id != ''")->fetchOne() . "\n";
echo "Total gerentes: " . $conn->executeQuery("SELECT COUNT(DISTINCT gerente_id) FROM d_unidade WHERE gerente_id IS NOT NULL AND gerente_id != ''")->fetchOne() . "\n";
echo "Total variavel: " . $conn->executeQuery("SELECT COUNT(*) FROM f_variavel")->fetchOne() . "\n";

