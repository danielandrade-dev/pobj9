<?php

declare(strict_types=1);

namespace Pobj\Api\Helpers;

final class RowMapper
{
    public static function map(array $row, array $mapping): array
    {
        $result = [];
        
        foreach ($mapping as $targetKey => $sourceKey) {
            if (is_callable($sourceKey)) {
                $result[$targetKey] = $sourceKey($row);
            } elseif (is_string($sourceKey)) {
                $result[$targetKey] = $row[$sourceKey] ?? null;
            } else {
                $result[$targetKey] = $sourceKey;
            }
        }
        
        return $result;
    }
    
    public static function toString($value): ?string
    {
        return $value !== null ? (string)$value : null;
    }
    
    public static function toFloat($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }
        
        if (is_numeric($value)) {
            return (float)$value;
        }
        
        return null;
    }
    
    public static function formatDate($value): ?string
    {
        return DateFormatter::toIsoDate($value);
    }
}

