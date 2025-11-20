<?php

declare(strict_types=1);

namespace Pobj\Api\Enums;

enum Cargo: int
{
    case GERENTE = 1;
    case GERENTE_GESTAO = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::GERENTE => 'Gerente',
            self::GERENTE_GESTAO => 'Gerente de Gestão',
        };
    }

    public static function fromId(int $id): self
    {
        return self::from($id);
    }

    public static function tryFromId(int $id): ?self
    {
        return self::tryFrom($id);
    }
}

