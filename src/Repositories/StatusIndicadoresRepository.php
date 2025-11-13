<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\Entity\DStatusIndicador;
use Pobj\Api\Enums\StatusIndicador;

class StatusIndicadoresRepository implements RepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return DStatusIndicador[]
     */
    public function findAll(): array
    {
        $entities = $this->entityManager
            ->getRepository(DStatusIndicador::class)
            ->createQueryBuilder('s')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult();

        if (empty($entities)) {
            return [];
        }

        return $entities;
    }

    /**
     * Converte entidades para array associativo (compatibilidade com código existente)
     * @return array<int, array<string, mixed>>
     */
    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        
        if (empty($entities)) {
            return StatusIndicador::getDefaults();
        }

        $result = [];
        foreach ($entities as $entity) {
            $result[] = [
                'id' => $entity->getId(),
                'status' => $entity->getStatus(),
            ];
        }

        return $result;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findAllForFilter(): array
    {
        $entities = $this->findAll();
        
        if (empty($entities)) {
            return StatusIndicador::getDefaultsForFilter();
        }

        $result = [];
        foreach ($entities as $entity) {
            $result[] = [
                'id' => $entity->getId(),
                'label' => $entity->getStatus(),
            ];
        }

        return $result;
    }
}
