<?php

declare(strict_types=1);

namespace Pobj\Api\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Pobj\Api\Helpers\EnvHelper;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use RuntimeException;

class DoctrineManager
{
    private static ?EntityManager $entityManager = null;

    public static function getEntityManager(): EntityManager
    {
        if (self::$entityManager !== null) {
            return self::$entityManager;
        }

        $isDevMode = EnvHelper::get('APP_ENV', 'production') !== 'production';
        $proxyDir = __DIR__ . '/../../var/cache/doctrine/proxies';
        $cache = null;

        if (!$isDevMode) {
            $cache = new FilesystemAdapter('', 0, __DIR__ . '/../../var/cache/doctrine');
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . '/../Entity'],
            $isDevMode,
            $proxyDir,
            $cache
        );

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

    private static function getDbHost(): string
    {
        $host = EnvHelper::get('DB_HOST');
        if (empty($host)) {
            throw new RuntimeException('DB_HOST não configurado no arquivo .env');
        }

        if (strpos($host, ':') !== false) {
            [$host] = explode(':', $host, 2);
        }

        if ($host === 'localhost') {
            $host = '127.0.0.1';
        }

        return (string) $host;
    }

    private static function getDbPort(): int
    {
        $host = EnvHelper::get('DB_HOST');
        if (!empty($host) && strpos($host, ':') !== false) {
            [, $port] = explode(':', $host, 2);
            return (int) $port;
        }

        $port = EnvHelper::get('DB_PORT');
        if ($port === null) {
            throw new RuntimeException('DB_PORT não configurado no arquivo .env');
        }

        return (int) $port;
    }

    private static function getDbUser(): string
    {
        $user = EnvHelper::get('DB_USER');
        if (empty($user)) {
            throw new RuntimeException('DB_USER não configurado no arquivo .env');
        }

        return (string) $user;
    }

    private static function getDbPassword(): string
    {
        return (string) EnvHelper::get('DB_PASSWORD', '');
    }

    private static function getDbName(): string
    {
        $database = EnvHelper::get('DB_NAME');
        if (empty($database)) {
            throw new RuntimeException('DB_NAME não configurado no arquivo .env');
        }

        return (string) $database;
    }
}
