<?php

declare(strict_types=1);

/**
 * Bootstrap da API - Carrega todas as dependências
 */

// Autoloader simples seguindo PSR-4
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

