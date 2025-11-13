<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
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
                'departamento' => $entity->getDepartamento(),
                'departamento_id' => $entity->getDepartamentoId(),
                'ordem_departamento' => $entity->getOrdemDepartamento(),
                'tipo' => $entity->getTipo(),
                'ordem_tipo' => $entity->getOrdemTipo(),
            ];
        }
        
        return $result;
    }
}

