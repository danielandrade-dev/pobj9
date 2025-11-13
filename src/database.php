<?php
declare(strict_types=1);

use Pobj\Api\Database\DatabaseConnection;

/**
 * Retorna (singleton) uma conexão PDO com o banco MySQL configurado.
 * Função de compatibilidade - use DatabaseConnection::getConnection() diretamente.
 *
 * @return \PDO
 */
function pobj_db(): PDO
{
    return DatabaseConnection::getConnection();
}

/**
 * Lê as variáveis de ambiente referentes ao banco.
 * Função de compatibilidade - use DatabaseConnection diretamente.
 *
 * @return array{host: string, port: int, user: string, password: string, database: string}
 */
function pobj_db_config(): array
{
    $host = \Pobj\Api\Helpers\EnvHelper::get('DB_HOST');
    if (empty($host)) {
        throw new \RuntimeException('DB_HOST não configurado no arquivo .env');
    }

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
