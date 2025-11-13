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

        // Suporta socket Unix (comum no Linux quando host é 'localhost')
        if ($config['host'] === 'localhost' && $config['port'] === 3306) {
            // Tenta usar socket Unix primeiro (mais rápido no Linux)
            $socketPaths = [
                '/var/run/mysqld/mysqld.sock',
                '/tmp/mysql.sock',
                '/var/lib/mysql/mysql.sock',
            ];
            
            $socketFound = false;
            foreach ($socketPaths as $socketPath) {
                if (file_exists($socketPath)) {
                    $dsn = sprintf(
                        'mysql:unix_socket=%s;dbname=%s;charset=utf8mb4',
                        $socketPath,
                        $config['database']
                    );
                    $socketFound = true;
                    break;
                }
            }
            
            if (!$socketFound) {
                // Fallback para TCP/IP
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                    $config['host'],
                    $config['port'],
                    $config['database']
                );
            }
        } else {
            // Usa TCP/IP para hosts remotos ou portas diferentes
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                $config['host'],
                $config['port'],
                $config['database']
            );
        }

        try {
            $pdo = new PDO($dsn, $config['user'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (\PDOException $exception) {
            $errorCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
            
            // Mensagens mais amigáveis baseadas no código de erro
            $userMessage = match (true) {
                $errorCode === 2002 || strpos($errorMessage, 'No such file or directory') !== false => 
                    sprintf(
                        'MySQL não está acessível. Verifique se o serviço está rodando em %s:%d. ' .
                        'Erro: %s',
                        $config['host'],
                        $config['port'],
                        $errorMessage
                    ),
                $errorCode === 1045 => 
                    'Credenciais inválidas. Verifique DB_USER e DB_PASSWORD no arquivo .env',
                $errorCode === 1049 => 
                    sprintf(
                        'Banco de dados "%s" não existe. Verifique DB_NAME no arquivo .env',
                        $config['database']
                    ),
                $errorCode === 2002 || strpos($errorMessage, 'Connection refused') !== false =>
                    sprintf(
                        'Conexão recusada em %s:%d. Verifique se o MySQL está rodando e a porta está correta.',
                        $config['host'],
                        $config['port']
                    ),
                default => 
                    sprintf(
                        'Erro ao conectar ao MySQL (%s): %s',
                        $errorCode,
                        $errorMessage
                    ),
            };
            
            throw new \RuntimeException($userMessage, 0, $exception);
        }

        return $pdo;
    }

    /**
     * Lê as variáveis de ambiente referentes ao banco
     *
     * @return array{host: string, port: int, user: string, password: string, database: string}
     * @throws \RuntimeException Se alguma variável obrigatória não estiver configurada
     */
    private static function getConfig(): array
    {
        $host = \Pobj\Api\Helpers\EnvHelper::get('DB_HOST');
        if (empty($host)) {
            throw new \RuntimeException('DB_HOST não configurado no arquivo .env');
        }

        // Suporta formato host:port
        if (strpos($host, ':') !== false) {
            [$host, $port] = explode(':', $host, 2);
            $port = (int) $port;
        } else {
            $port = \Pobj\Api\Helpers\EnvHelper::get('DB_PORT');
            if ($port === null) {
                throw new \RuntimeException('DB_PORT não configurado no arquivo .env');
            }
            $port = (int) $port;
        }

        $user = \Pobj\Api\Helpers\EnvHelper::get('DB_USER');
        if (empty($user)) {
            throw new \RuntimeException('DB_USER não configurado no arquivo .env');
        }

        $password = \Pobj\Api\Helpers\EnvHelper::get('DB_PASSWORD', '');

        $database = \Pobj\Api\Helpers\EnvHelper::get('DB_NAME');
        if (empty($database)) {
            throw new \RuntimeException('DB_NAME não configurado no arquivo .env');
        }

        return [
            'host' => (string) $host,
            'port' => $port,
            'user' => (string) $user,
            'password' => (string) $password,
            'database' => (string) $database,
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

