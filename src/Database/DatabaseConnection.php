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
        static $pdo = null;
        if ($pdo instanceof PDO) {
            return $pdo;
        }

        $config = self::getConfig();

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $config['host'],
            $config['port'],
            $config['database']
        );

        try {
            $pdo = new PDO($dsn, $config['user'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (\PDOException $exception) {
            throw new \RuntimeException(
                'Não foi possível conectar ao MySQL: ' . $exception->getMessage(),
                0,
                $exception
            );
        }

        return $pdo;
    }

    /**
     * Lê as variáveis de ambiente referentes ao banco
     *
     * @return array{host: string, port: int, user: string, password: string, database: string}
     */
    private static function getConfig(): array
    {
        $host = (string) \Pobj\Api\Helpers\EnvHelper::get('DB_HOST', 'localhost:3307');
        // Suporta formato host:port
        if (strpos($host, ':') !== false) {
            [$host, $port] = explode(':', $host, 2);
            $port = (int) $port;
        } else {
            $port = (int) \Pobj\Api\Helpers\EnvHelper::get('DB_PORT', 3306);
        }

        return [
            'host' => $host,
            'port' => $port,
            'user' => (string) \Pobj\Api\Helpers\EnvHelper::get('DB_USER', 'root'),
            'password' => (string) \Pobj\Api\Helpers\EnvHelper::get('DB_PASSWORD', ''),
            'database' => (string) \Pobj\Api\Helpers\EnvHelper::get('DB_NAME', 'POBJ'),
        ];
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

