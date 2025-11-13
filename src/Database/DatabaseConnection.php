<?php

declare(strict_types=1);

namespace Pobj\Api\Database;

use PDO;
use PDOException;
use Pobj\Api\Helpers\Logger;
use Pobj\Api\Helpers\EnvHelper;
use RuntimeException;
use Throwable;

class DatabaseConnection
{
    public static function getConnection(): PDO
    {
        static $pdo = null;
        if ($pdo instanceof PDO) {
            return $pdo;
        }

        try {
            $em = DoctrineManager::getEntityManager();
            $connection = $em->getConnection();
            $nativeConnection = $connection->getNativeConnection();
            
            if ($nativeConnection instanceof PDO) {
                return $nativeConnection;
            }
        } catch (Throwable $e) {
            Logger::warning('Doctrine não disponível, usando conexão PDO direta', [
                'error' => $e->getMessage(),
            ]);
        }

        $config = self::getConfig();

        $host = $config['host'];
        $useSocket = false;
        
        if ($host === 'localhost' && $config['port'] === 3306) {
            $socketPaths = [
                '/var/run/mysqld/mysqld.sock',
                '/tmp/mysql.sock',
                '/var/lib/mysql/mysql.sock',
            ];
            
            foreach ($socketPaths as $socketPath) {
                if (file_exists($socketPath) && is_readable($socketPath)) {
                    $dsn = sprintf(
                        'mysql:unix_socket=%s;dbname=%s;charset=utf8mb4',
                        $socketPath,
                        $config['database']
                    );
                    $useSocket = true;
                    break;
                }
            }
        }
        
        if (!$useSocket) {
            if ($host === 'localhost') {
                $host = '127.0.0.1';
            }
            
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                $host,
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
        } catch (PDOException $exception) {
            $errorCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
            
            $userMessage = match (true) {
                $errorCode === 2002 || strpos($errorMessage, 'No such file or directory') !== false,
                strpos($errorMessage, 'Connection refused') !== false => 
                    sprintf(
                        'MySQL não está acessível em %s:%d. ' .
                        'Verifique se o serviço MySQL está rodando: sudo systemctl start mysql (ou mariadb). ' .
                        'Erro técnico: %s',
                        $config['host'],
                        $config['port'],
                        $errorMessage
                    ),
                $errorCode === 1045 => 
                    'Credenciais inválidas. Verifique DB_USER e DB_PASSWORD no arquivo .env',
                $errorCode === 1049 => 
                    sprintf(
                        'Banco de dados "%s" não existe. Verifique DB_NAME no arquivo .env ou crie o banco primeiro.',
                        $config['database']
                    ),
                default => 
                    sprintf(
                        'Erro ao conectar ao MySQL (código %s): %s',
                        $errorCode,
                        $errorMessage
                    ),
            };
            
            throw new RuntimeException($userMessage, 0, $exception);
        }

        return $pdo;
    }

    private static function getConfig(): array
    {
        $host = EnvHelper::get('DB_HOST');
        if (empty($host)) {
            throw new RuntimeException('DB_HOST não configurado no arquivo .env');
        }

        if (strpos($host, ':') !== false) {
            [$host, $port] = explode(':', $host, 2);
            $port = (int) $port;
        } else {
            $port = EnvHelper::get('DB_PORT');
            if ($port === null) {
                throw new RuntimeException('DB_PORT não configurado no arquivo .env');
            }
            $port = (int) $port;
        }

        $user = EnvHelper::get('DB_USER');
        if (empty($user)) {
            throw new RuntimeException('DB_USER não configurado no arquivo .env');
        }

        $password = EnvHelper::get('DB_PASSWORD', '');

        $database = EnvHelper::get('DB_NAME');
        if (empty($database)) { 
            throw new RuntimeException('DB_NAME não configurado no arquivo .env');
        }

        return [
            'host' => (string) $host,
            'port' => $port,
            'user' => (string) $user,
            'password' => (string) $password,
            'database' => (string) $database,
        ];
    }

    public static function query(PDO $pdo, string $sql, array $bind = []): array
    {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
