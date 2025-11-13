<?php

declare(strict_types=1);

/**
 * Bootstrap da API - Carrega todas as dependências
 */

// Carrega autoloader do Composer se disponível, senão usa autoloader simples
$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
} else {
    // Fallback: autoloader simples seguindo PSR-4
    spl_autoload_register(function (string $className): void {
        $prefix = 'Pobj\\Api\\';
        $baseDir = __DIR__ . '/';

        $len = strlen($prefix);
        if (strncmp($prefix, $className, $len) !== 0) {
            return;
        }

        $relativeClass = substr($className, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    });

    // Carrega funções helper globais para compatibilidade
    require_once __DIR__ . '/Helpers/functions.php';
}

