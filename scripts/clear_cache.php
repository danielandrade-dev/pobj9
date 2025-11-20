<?php

/**
 * Script para limpar o cache do Doctrine
 */

$cacheDir = __DIR__ . '/../var/cache/doctrine';
$proxyDir = __DIR__ . '/../var/cache/doctrine/proxies';

echo "Limpando cache do Doctrine...\n";

// Limpa o diretório de cache
if (is_dir($cacheDir)) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($cacheDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($files as $file) {
        if ($file->isFile() && $file->getFilename() !== '.gitkeep') {
            unlink($file->getPathname());
        } elseif ($file->isDir()) {
            rmdir($file->getPathname());
        }
    }
    echo "✓ Cache limpo\n";
} else {
    echo "⚠ Diretório de cache não encontrado\n";
}

// Limpa proxies se existir
if (is_dir($proxyDir)) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($proxyDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            unlink($file->getPathname());
        } elseif ($file->isDir()) {
            rmdir($file->getPathname());
        }
    }
    echo "✓ Proxies limpos\n";
}

// Reseta o EntityManager em memória (se estiver usando DoctrineManager)
if (class_exists('Pobj\Api\Database\DoctrineManager')) {
    Pobj\Api\Database\DoctrineManager::reset();
    echo "✓ EntityManager resetado\n";
}

echo "\n✅ Cache do Doctrine limpo com sucesso!\n";

