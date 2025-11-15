<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

abstract class BaseFactDTO
{
    public function toArray(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }
}

