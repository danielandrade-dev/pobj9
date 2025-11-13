<?php

declare(strict_types=1);

namespace Pobj\Api\Helpers;

class EnvHelper
{
    private static bool $loaded = false;

    public static function load(): void
    {
        if (self::$loaded) {
            return;
        }
        self::$loaded = true;

        $envFiles = [
            __DIR__ . '/../../config/.env',
            __DIR__ . '/../../.env',
            __DIR__ . '/../../../.env',
            __DIR__ . '/../../../config/.env',
        ];

        foreach ($envFiles as $file) {
            if (is_file($file) && is_readable($file)) {
                $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                if ($lines === false) {
                    continue;
                }
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || strpos($line, '#') === 0) {
                        continue;
                    }
                    if (strpos($line, '=') !== false) {
                        [$key, $value] = explode('=', $line, 2);
                        $key = trim($key);
                        $value = trim($value);
                        $value = trim($value, '"\'');
                        if ($key !== '' && !isset($_ENV[$key])) {
                            $_ENV[$key] = $value;
                            putenv("$key=$value");
                        }
                    }
                }
                break;
            }
        }
    }

    public static function get(string $key, $default = null)
    {
        self::load();

        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }

        return $default;
    }
}
