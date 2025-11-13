<?php

declare(strict_types=1);

namespace Pobj\Api\Enums;

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
    case OPTIONS = 'OPTIONS';

    public static function fromString(string $value): self
    {
        return self::from($value);
    }

    public static function tryFromString(string $value): ?self
    {
        return self::tryFrom($value);
    }
}

