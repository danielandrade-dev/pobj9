<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\OmegaStructureDTO;
use Pobj\Api\Entity\OmegaDepartamento;
use Pobj\Api\Interfaces\RepositoryInterface;

class OmegaStructureRepository implements RepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return OmegaDepartamento[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(OmegaDepartamento::class)
            ->createQueryBuilder('d')
            ->orderBy('d.ordemDepartamento', 'ASC')
            ->addOrderBy('d.ordemTipo', 'ASC')
            ->addOrderBy('d.departamento', 'ASC')
            ->addOrderBy('d.tipo', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        
        return array_map(function (OmegaDepartamento $entity) {
            $dto = new OmegaStructureDTO(
                departamento: $entity->getDepartamento(),
                tipo: $entity->getTipo(),
                departamentoId: $entity->getDepartamentoId(),
                ordemDepartamento: $entity->getOrdemDepartamento(),
                ordemTipo: $entity->getOrdemTipo(),
            );
            
            return $dto->toArray();
        }, $entities);
    }
}

