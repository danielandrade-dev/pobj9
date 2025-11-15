<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\OmegaTicketDTO;
use Pobj\Api\Entity\OmegaChamado;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Interfaces\RepositoryInterface;

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

    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        
        return array_map(function (OmegaChamado $entity) {
            $opened = $entity->getOpened()?->format('Y-m-d H:i:s');
            $updated = $entity->getUpdated()?->format('Y-m-d H:i:s');
            $dueDate = $entity->getDueDate()?->format('Y-m-d H:i:s');
            
            $dto = new OmegaTicketDTO(
                id: $entity->getId(),
                subject: $entity->getSubject(),
                company: $entity->getCompany(),
                productId: $entity->getProductId(),
                productLabel: $entity->getProductLabel(),
                family: $entity->getFamily(),
                section: $entity->getSection(),
                queue: $entity->getQueue(),
                category: $entity->getCategory(),
                status: $entity->getStatus(),
                priority: $entity->getPriority(),
                opened: $opened,
                updated: $updated,
                dueDate: $dueDate,
                requesterId: $entity->getRequesterId(),
                ownerId: $entity->getOwnerId(),
                teamId: $entity->getTeamId(),
                history: $entity->getHistory(),
                diretoria: $entity->getDiretoria(),
                gerencia: $entity->getGerencia(),
                agencia: $entity->getAgencia(),
                gerenteGestao: $entity->getGerenteGestao(),
                gerente: $entity->getGerente(),
                credit: $entity->getCredit(),
                attachment: $entity->getAttachment(),
            );
            
            return $dto->toArray();
        }, $entities);
    }
}

