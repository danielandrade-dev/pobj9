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
    $host = (string) \Pobj\Api\Helpers\EnvHelper::get('DB_HOST', 'localhost:3307');
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
