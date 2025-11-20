<?php

declare(strict_types=1);

namespace Pobj\Api\Enums;

enum StatusIndicador: string
{
    case ATINGIDO = '01';
    case NAO_ATINGIDO = '02';
    case TODOS = '03';

    public function getLabel(): string
    {
        return match ($this) {
            self::ATINGIDO => 'Atingido',
            self::NAO_ATINGIDO => 'Não Atingido',
            self::TODOS => 'Todos',
        };
    }

    public static function getDefaults(): array
    {
        return [
            ['id' => self::ATINGIDO->value, 'label' => self::ATINGIDO->getLabel()],
            ['id' => self::NAO_ATINGIDO->value, 'label' => self::NAO_ATINGIDO->getLabel()],
            ['id' => self::TODOS->value, 'label' => self::TODOS->getLabel()],
        ];
    }

    public static function getDefaultsForFilter(): array
    {
        return [
            ['id' => self::ATINGIDO->value, 'label' => self::ATINGIDO->getLabel()],
            ['id' => self::NAO_ATINGIDO->value, 'label' => self::NAO_ATINGIDO->getLabel()],
            ['id' => self::TODOS->value, 'label' => self::TODOS->getLabel()],
        ];
    }
}

