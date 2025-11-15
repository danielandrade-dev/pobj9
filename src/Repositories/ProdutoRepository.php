<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\ProdutoDTO;
use Pobj\Api\Entity\DProduto;
use Pobj\Api\Helpers\RowMapper;
use Pobj\Api\Interfaces\RepositoryInterface;

class ProdutoRepository implements RepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return DProduto[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(DProduto::class)
            ->createQueryBuilder('p')
            ->orderBy('p.familia', 'ASC')
            ->addOrderBy('p.indicador', 'ASC')
            ->addOrderBy('p.subindicador', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        
        return array_map(function (DProduto $entity) {
            $dto = new ProdutoDTO(
                id: $entity->getId(),
                idFamilia: (string)$entity->getIdFamilia(),
                familia: $entity->getFamilia(),
                idIndicador: RowMapper::toString($entity->getIdIndicador()),
                indicador: $entity->getIndicador(),
                idSubindicador: RowMapper::toString($entity->getIdSubindicador()),
                subindicador: $entity->getSubindicador(),
                peso: RowMapper::toFloat($entity->getPeso()),
            );
            
            return $dto->toArray();
        }, $entities);
    }
}

