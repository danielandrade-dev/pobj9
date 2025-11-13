<?php

declare(strict_types=1);

namespace Pobj\Api\Enums;

enum FiltroNivel: string
{
    case SEGMENTOS = 'segmentos';
    case DIRETORIAS = 'diretorias';
    case REGIONAIS = 'regionais';
    case AGENCIAS = 'agencias';
    case GGESTOES = 'ggestoes';
    case GERENTES = 'gerentes';
    case STATUS_INDICADORES = 'status_indicadores';

    public static function fromString(string $value): self
    {
        return self::from($value);
    }

    public static function tryFromString(string $value): ?self
    {
        return self::tryFrom($value);
    }
}

