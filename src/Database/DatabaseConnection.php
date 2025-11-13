<?php

declare(strict_types=1);

namespace Pobj\Api\Database;

use PDO;
use PDOException;

/**
 * Gerenciador de conexão com banco de dados
 */
class DatabaseConnection
{
    /**
     * Retorna uma conexão PDO configurada
     *
     * @throws PDOException
     */
    public static function getConnection(): PDO
    {
        $dbHost = getenv('DB_HOST') ?: 'localhost:3307';
        $dbName = getenv('DB_NAME') ?: 'POBJ';
        $dbUser = getenv('DB_USER') ?: 'root';
        $dbPass = getenv('DB_PASS') ?: '';
        $dbCharset = 'utf8mb4';

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $dbHost,
            $dbName,
            $dbCharset
        );

        return new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    /**
     * Executa uma query SQL preparada e retorna os resultados
     *
     * @param array<string, mixed> $bind
     * @return array<int, array<string, mixed>>
     */
    public static function query(PDO $pdo, string $sql, array $bind = []): array
    {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

