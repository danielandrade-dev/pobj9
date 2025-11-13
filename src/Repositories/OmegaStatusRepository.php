<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\Entity\OmegaStatus;

class OmegaStatusRepository implements RepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return OmegaStatus[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(OmegaStatus::class)
            ->createQueryBuilder('s')
            ->orderBy('s.ordem', 'ASC')
            ->addOrderBy('s.label', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Converte entidades para array associativo (compatibilidade com código existente)
     * @return array<int, array<string, mixed>>
     */
    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        $result = [];
        
        foreach ($entities as $entity) {
            $result[] = [
                'id' => $entity->getId(),
                'label' => $entity->getLabel(),
                'tone' => $entity->getTone(),
                'descricao' => $entity->getDescricao(),
                'ordem' => $entity->getOrdem(),
                'departamento_id' => $entity->getDepartamentoId(),
            ];
        }
        
        return $result;
    }
}

