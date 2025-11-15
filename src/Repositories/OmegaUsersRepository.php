<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\OmegaUserDTO;
use Pobj\Api\Entity\OmegaUsuario;
use Pobj\Api\Interfaces\RepositoryInterface;

class OmegaUsersRepository implements RepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return OmegaUsuario[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(OmegaUsuario::class)
            ->createQueryBuilder('u')
            ->orderBy('u.nome', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        
        return array_map(function (OmegaUsuario $entity) {
            $dto = new OmegaUserDTO(
                id: $entity->getId(),
                nome: $entity->getNome(),
                funcional: $entity->getFuncional(),
                matricula: $entity->getMatricula(),
                cargo: $entity->getCargo(),
                usuario: $entity->isUsuario(),
                analista: $entity->isAnalista(),
                supervisor: $entity->isSupervisor(),
                admin: $entity->isAdmin(),
                encarteiramento: $entity->isEncarteiramento(),
                meta: $entity->isMeta(),
                orcamento: $entity->isOrcamento(),
                pobj: $entity->isPobj(),
                matriz: $entity->isMatriz(),
                outros: $entity->isOutros(),
            );
            
            return $dto->toArray();
        }, $entities);
    }
}

