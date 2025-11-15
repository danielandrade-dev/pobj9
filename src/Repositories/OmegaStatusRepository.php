<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\OmegaStatusDTO;
use Pobj\Api\Entity\OmegaStatus;
use Pobj\Api\Interfaces\RepositoryInterface;

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

    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        
        return array_map(function (OmegaStatus $entity) {
            $dto = new OmegaStatusDTO(
                id: $entity->getId(),
                label: $entity->getLabel(),
                tone: $entity->getTone(),
                descricao: $entity->getDescricao(),
                ordem: $entity->getOrdem(),
                departamentoId: $entity->getDepartamentoId(),
            );
            
            return $dto->toArray();
        }, $entities);
    }
}

