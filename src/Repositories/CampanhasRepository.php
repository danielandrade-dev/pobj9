<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\CampanhasDTO;
use Pobj\Api\Entity\FCampanhas;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Helpers\RowMapper;
use Pobj\Api\Interfaces\RepositoryInterface;

class CampanhasRepository implements RepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return FCampanhas[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(FCampanhas::class)
            ->createQueryBuilder('c')
            ->orderBy('c.data', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        
        return array_map(function (FCampanhas $entity) {
            $dataIso = DateFormatter::toIsoDate($entity->getData());
            
            $dto = new CampanhasDTO(
                registroId: $entity->getCampanhaId(),
                sprintId: $entity->getSprintId(),
                segmento: $entity->getSegmento(),
                segmentoId: $entity->getSegmentoId(),
                diretoriaId: $entity->getDiretoriaId(),
                diretoriaNome: $entity->getDiretoriaNome(),
                gerenciaId: $entity->getGerenciaRegionalId(),
                gerenciaNome: $entity->getRegionalNome(),
                agenciaId: $entity->getAgenciaId(),
                agenciaNome: $entity->getAgenciaNome(),
                gerenteGestaoId: $entity->getGerenteGestaoId(),
                gerenteGestaoNome: $entity->getGerenteGestaoNome(),
                gerenteId: $entity->getGerenteId(),
                gerenteNome: $entity->getGerenteNome(),
                familiaId: $entity->getFamiliaId(),
                idIndicador: $entity->getIdIndicador(),
                dsIndicador: $entity->getDsIndicador(),
                subproduto: $entity->getSubproduto(),
                subindicadorCodigo: $entity->getSubindicadorCodigo(),
                familiaCodigo: $entity->getFamiliaCodigo(),
                indicadorCodigo: $entity->getIndicadorCodigo(),
                carteira: $entity->getCarteira(),
                data: $dataIso,
                competencia: $dataIso,
                linhas: RowMapper::toFloat($entity->getLinhas()),
                cash: RowMapper::toFloat($entity->getCash()),
                conquista: RowMapper::toFloat($entity->getConquista()),
                atividade: $entity->getAtividade(),
            );
            
            return $dto->toArray();
        }, $entities);
    }
}

