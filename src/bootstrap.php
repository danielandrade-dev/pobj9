<?php

declare(strict_types=1);

$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
} else {
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
}

use Pobj\Api\Helpers\ErrorHandler;
use Pobj\Api\Http\ViewHelpers;

ErrorHandler::register();
ViewHelpers::registerDefaults();
