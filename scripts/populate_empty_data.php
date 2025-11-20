<?php

require __DIR__ . '/../vendor/autoload.php';

use Pobj\Api\Database\DoctrineManager;

$em = DoctrineManager::getEntityManager();
$conn = $em->getConnection();

echo "Populando dados vazios...\n";

// 1. Atualizar d_estrutura com gerentes e gerentes de gestão
echo "Atualizando d_estrutura com gerentes...\n";
$conn->executeStatement("
    UPDATE d_estrutura 
    SET cargo = CASE 
        WHEN cargo IS NULL OR cargo = '' THEN CONCAT('Gerente Gestão ', regional)
        ELSE cargo
    END
    WHERE id_regional IS NOT NULL
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
echo "Total gerentes_gestao: " . $conn->executeQuery("SELECT COUNT(DISTINCT funcional) FROM d_estrutura WHERE cargo LIKE '%Gerente Gestão%' AND funcional IS NOT NULL AND funcional != ''")->fetchOne() . "\n";
echo "Total gerentes: " . $conn->executeQuery("SELECT COUNT(DISTINCT funcional) FROM d_estrutura WHERE cargo LIKE '%Gerente%' AND funcional IS NOT NULL AND funcional != ''")->fetchOne() . "\n";
echo "Total variavel: " . $conn->executeQuery("SELECT COUNT(*) FROM f_variavel")->fetchOne() . "\n";

