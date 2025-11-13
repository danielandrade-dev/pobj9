<?php

declare(strict_types=1);

namespace Pobj\Api\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Pobj\Api\Helpers\EnvHelper;

/**
 * Gerenciador do Doctrine ORM
 */
class DoctrineManager
{
    private static ?EntityManager $entityManager = null;

    /**
     * Retorna o EntityManager do Doctrine
     *
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public static function getEntityManager(): EntityManager
    {
        if (self::$entityManager !== null) {
            return self::$entityManager;
        }

        // Configuração do Doctrine
        $isDevMode = EnvHelper::get('APP_ENV', 'production') !== 'production';
        $proxyDir = __DIR__ . '/../../var/cache/doctrine/proxies';
        $cache = null;

        if (!$isDevMode) {
            // Em produção, usa cache de arquivos
            $cache = new \Symfony\Component\Cache\Adapter\FilesystemAdapter('', 0, __DIR__ . '/../../var/cache/doctrine');
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . '/../Entity'],
            $isDevMode,
            $proxyDir,
            $cache
        );

        // Configuração da conexão
        $connectionParams = [
            'driver' => 'pdo_mysql',
            'host' => self::getDbHost(),
            'port' => self::getDbPort(),
            'user' => self::getDbUser(),
            'password' => self::getDbPassword(),
            'dbname' => self::getDbName(),
            'charset' => 'utf8mb4',
        ];

        $connection = DriverManager::getConnection($connectionParams, $config);
        self::$entityManager = new EntityManager($connection, $config);

        return self::$entityManager;
    }

    /**
     * Retorna o host do banco de dados
     */
    private static function getDbHost(): string
    {
        $host = EnvHelper::get('DB_HOST');
        if (empty($host)) {
            throw new \RuntimeException('DB_HOST não configurado no arquivo .env');
        }

        // Suporta formato host:port
        if (strpos($host, ':') !== false) {
            [$host] = explode(':', $host, 2);
        }

        // Converte localhost para 127.0.0.1 para forçar TCP/IP
        // Isso evita problemas com socket Unix que pode não existir ou não estar acessível
        if ($host === 'localhost') {
            $host = '127.0.0.1';
        }

        return (string) $host;
    }

    /**
     * Retorna a porta do banco de dados
     */
    private static function getDbPort(): int
    {
        $host = EnvHelper::get('DB_HOST');
        if (!empty($host) && strpos($host, ':') !== false) {
            [, $port] = explode(':', $host, 2);
            return (int) $port;
        }

        $port = EnvHelper::get('DB_PORT');
        if ($port === null) {
            throw new \RuntimeException('DB_PORT não configurado no arquivo .env');
        }

        return (int) $port;
    }

    /**
     * Retorna o usuário do banco de dados
     */
    private static function getDbUser(): string
    {
        $user = EnvHelper::get('DB_USER');
        if (empty($user)) {
            throw new \RuntimeException('DB_USER não configurado no arquivo .env');
        }

        return (string) $user;
    }

    /**
     * Retorna a senha do banco de dados
     */
    private static function getDbPassword(): string
    {
        return (string) EnvHelper::get('DB_PASSWORD', '');
    }

    /**
     * Retorna o nome do banco de dados
     */
    private static function getDbName(): string
    {
        $database = EnvHelper::get('DB_NAME');
        if (empty($database)) {
            throw new \RuntimeException('DB_NAME não configurado no arquivo .env');
        }

        return (string) $database;
    }
}

