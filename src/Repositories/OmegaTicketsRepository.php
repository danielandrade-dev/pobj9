<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\Entity\OmegaChamado;

class OmegaTicketsRepository implements RepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return OmegaChamado[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(OmegaChamado::class)
            ->createQueryBuilder('c')
            ->orderBy('c.updated', 'DESC')
            ->addOrderBy('c.opened', 'DESC')
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
                'subject' => $entity->getSubject(),
                'company' => $entity->getCompany(),
                'product_id' => $entity->getProductId(),
                'product_label' => $entity->getProductLabel(),
                'family' => $entity->getFamily(),
                'section' => $entity->getSection(),
                'queue' => $entity->getQueue(),
                'category' => $entity->getCategory(),
                'status' => $entity->getStatus(),
                'priority' => $entity->getPriority(),
                'opened' => $entity->getOpened()?->format('Y-m-d H:i:s'),
                'updated' => $entity->getUpdated()?->format('Y-m-d H:i:s'),
                'due_date' => $entity->getDueDate()?->format('Y-m-d H:i:s'),
                'requester_id' => $entity->getRequesterId(),
                'owner_id' => $entity->getOwnerId(),
                'team_id' => $entity->getTeamId(),
                'history' => $entity->getHistory(),
                'diretoria' => $entity->getDiretoria(),
                'gerencia' => $entity->getGerencia(),
                'agencia' => $entity->getAgencia(),
                'gerente_gestao' => $entity->getGerenteGestao(),
                'gerente' => $entity->getGerente(),
                'credit' => $entity->getCredit(),
                'attachment' => $entity->getAttachment(),
            ];
        }
        
        return $result;
    }
}

