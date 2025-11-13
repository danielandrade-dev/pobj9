<?php

declare(strict_types=1);

namespace Pobj\Api\Database;

use PDO;
use PDOException;

/**
 * Gerenciador de conexão com banco de dados
 * 
 * Gerencia conexões PDO com o banco de dados MySQL.
 * Internamente, tenta usar a conexão do Doctrine para evitar múltiplas conexões.
 * Se o Doctrine não estiver disponível, cria uma conexão PDO direta.
 */
class DatabaseConnection
{
    /**
     * Retorna uma conexão PDO configurada
     * 
     * Usa a conexão do Doctrine internamente para evitar múltiplas conexões.
     *
     * @throws PDOException
     */
    public static function getConnection(): PDO
    {
        static $pdo = null;
        if ($pdo instanceof PDO) {
            return $pdo;
        }

        // Tenta usar a conexão do Doctrine primeiro (mais eficiente - reutiliza conexão)
        try {
            $em = DoctrineManager::getEntityManager();
            $connection = $em->getConnection();
            $nativeConnection = $connection->getNativeConnection();
            
            // O Doctrine DBAL retorna PDO quando usa driver pdo_mysql
            if ($nativeConnection instanceof PDO) {
                return $nativeConnection;
            }
        } catch (\Throwable $e) {
            // Se Doctrine falhar, cria conexão PDO direta (fallback)
            \Pobj\Api\Helpers\Logger::warning('Doctrine não disponível, usando conexão PDO direta', [
                'error' => $e->getMessage(),
            ]);
        }

        // Fallback: cria conexão PDO direta
        $config = self::getConfig();

        // Para Docker ou portas não padrão, sempre usa TCP/IP
        // Socket Unix só é usado se host for 'localhost', porta 3306 E socket existir
        $host = $config['host'];
        $useSocket = false;
        
        // Se porta não é 3306 (padrão), sempre usa TCP/IP (comum em Docker)
        if ($host === 'localhost' && $config['port'] === 3306) {
            // Tenta usar socket Unix primeiro (mais rápido no Linux nativo)
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
        
        // Se não encontrou socket OU porta não é padrão, usa TCP/IP
        // Para Docker, sempre converte localhost para 127.0.0.1 para forçar TCP/IP
        if (!$useSocket) {
            // Converte localhost para 127.0.0.1 para garantir TCP/IP (importante para Docker)
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
        } catch (\PDOException $exception) {
            $errorCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
            
            // Mensagens mais amigáveis baseadas no código de erro
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

