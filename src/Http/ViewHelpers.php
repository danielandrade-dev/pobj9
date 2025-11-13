<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

/**
 * Helpers padrão para uso nas views
 * 
 * Exemplo de uso nas views:
 * @helper('formatDate', '2024-01-01')
 * @helper('formatCurrency', 1234.56)
 * @helper('asset', 'script.js')
 */
class ViewHelpers
{
    public static function registerDefaults(): void
    {
        // Helper para formatar datas
        ViewHelper::register('formatDate', function (string $date, string $format = 'd/m/Y'): string {
            $timestamp = strtotime($date);
            if ($timestamp === false) {
                return $date;
            }
            return date($format, $timestamp);
        });

        // Helper para formatar moeda
        ViewHelper::register('formatCurrency', function ($value, string $currency = 'R$'): string {
            if (!is_numeric($value)) {
                return (string) $value;
            }
            return $currency . ' ' . number_format((float) $value, 2, ',', '.');
        });

        // Helper para gerar URLs de assets
        ViewHelper::register('asset', function (string $path): string {
            // Remove barras iniciais
            $path = ltrim($path, '/');
            // Se não começar com public/, adiciona
            if (!str_starts_with($path, 'public/')) {
                $path = 'public/' . $path;
            }
            return $path;
        });

        // Helper para formatar números
        ViewHelper::register('formatNumber', function ($value, int $decimals = 0): string {
            if (!is_numeric($value)) {
                return (string) $value;
            }
            return number_format((float) $value, $decimals, ',', '.');
        });

        // Helper para escapar HTML
        ViewHelper::register('e', function (string $value): string {
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        });

        // Helper para verificar se variável existe e não é vazia
        ViewHelper::register('isset', function ($value): bool {
            return isset($value) && $value !== '' && $value !== null;
        });

        // Helper para gerar classes CSS condicionais
        ViewHelper::register('class', function (...$classes): string {
            $result = [];
            foreach ($classes as $class) {
                if (is_string($class) && !empty($class)) {
                    $result[] = $class;
                } elseif (is_array($class)) {
                    foreach ($class as $key => $value) {
                        if ($value) {
                            $result[] = is_string($key) ? $key : $value;
                        }
                    }
                }
            }
            return implode(' ', $result);
        });
    }
}

