<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

class ViewHelper
{
    private static array $helpers = [];

    public static function register(string $name, callable $callback): void
    {
        self::$helpers[$name] = $callback;
    }

    public static function call(string $name, ...$args)
    {
        if (!isset(self::$helpers[$name])) {
            throw new \RuntimeException("Helper não encontrado: {$name}");
        }

        return call_user_func(self::$helpers[$name], ...$args);
    }

    public static function has(string $name): bool
    {
        return isset(self::$helpers[$name]);
    }

    public static function getAll(): array
    {
        return self::$helpers;
    }
}

