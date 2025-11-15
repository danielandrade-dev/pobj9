<?php

declare(strict_types=1);

namespace Pobj\Api\Database;

use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;

class MigrationsConfiguration
{
    public static function getDependencyFactory(): DependencyFactory
    {
        $em = DoctrineManager::getEntityManager();
        
        $migrationsDir = realpath(__DIR__ . '/../../migrations') ?: __DIR__ . '/../../migrations';
        $migrationsNamespace = 'Pobj\\Api\\Migrations';
        
        // Configuração das migrations
        $configurationArray = new ConfigurationArray([
            'table_storage' => [
                'table_name' => 'doctrine_migration_versions',
            ],
            'migrations_paths' => [
                $migrationsNamespace => $migrationsDir,
            ],
            'all_or_nothing' => true,
            'check_database_platform' => true,
        ]);
        
        return DependencyFactory::fromEntityManager(
            new ExistingConfiguration($configurationArray->getConfiguration()),
            new \Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager($em)
        );
    }
}

