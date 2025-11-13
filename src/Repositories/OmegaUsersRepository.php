<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
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
                'nome' => $entity->getNome(),
                'funcional' => $entity->getFuncional(),
                'matricula' => $entity->getMatricula(),
                'cargo' => $entity->getCargo(),
                'usuario' => $entity->isUsuario() ? 1 : 0,
                'analista' => $entity->isAnalista() ? 1 : 0,
                'supervisor' => $entity->isSupervisor() ? 1 : 0,
                'admin' => $entity->isAdmin() ? 1 : 0,
                'encarteiramento' => $entity->isEncarteiramento() ? 1 : 0,
                'meta' => $entity->isMeta() ? 1 : 0,
                'orcamento' => $entity->isOrcamento() ? 1 : 0,
                'pobj' => $entity->isPobj() ? 1 : 0,
                'matriz' => $entity->isMatriz() ? 1 : 0,
                'outros' => $entity->isOutros() ? 1 : 0,
            ];
        }
        
        return $result;
    }
}

