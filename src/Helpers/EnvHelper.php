<?php

declare(strict_types=1);

namespace Pobj\Api\Helpers;

/**
 * Helper para gerenciar variáveis de ambiente
 */
class EnvHelper
{
    private static bool $loaded = false;

    /**
     * Carrega variáveis de ambiente de arquivos .env
     */
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
                    // Ignora comentários e linhas vazias
                    if ($line === '' || strpos($line, '#') === 0) {
                        continue;
                    }
                    // Processa linhas no formato KEY=VALUE
                    if (strpos($line, '=') !== false) {
                        [$key, $value] = explode('=', $line, 2);
                        $key = trim($key);
                        $value = trim($value);
                        // Remove aspas se houver
                        $value = trim($value, '"\'');
                        if ($key !== '' && !isset($_ENV[$key])) {
                            $_ENV[$key] = $value;
                            putenv("$key=$value");
                        }
                    }
                }
                break; // Usa o primeiro arquivo encontrado
            }
        }
    }

    /**
     * Lê uma variável de ambiente
     *
     * @param string $key Nome da variável
     * @param mixed $default Valor padrão se não encontrado
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        self::load();

        // Tenta $_ENV primeiro
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        // Tenta getenv()
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }

        return $default;
    }
}

