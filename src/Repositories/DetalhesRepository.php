<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\DetalhesDTO;
use Pobj\Api\Entity\FDetalhes;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Helpers\RowMapper;
use Pobj\Api\Interfaces\RepositoryInterface;

class DetalhesRepository implements RepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return FDetalhes[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(FDetalhes::class)
            ->createQueryBuilder('d')
            ->orderBy('d.data', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllAsArray(): array
    {
        $entities = $this->findAll();
        
        return array_map(function (FDetalhes $entity) {
            $dataIso = DateFormatter::toIsoDate($entity->getData());
            $competenciaIso = DateFormatter::toIsoDate($entity->getCompetencia());
            
            $dto = new DetalhesDTO(
                registroId: $entity->getRegistroId(),
                segmento: $entity->getSegmento(),
                segmentoId: $entity->getSegmentoId(),
                diretoriaId: $entity->getDiretoriaId(),
                diretoriaNome: $entity->getDiretoriaNome(),
                gerenciaId: $entity->getGerenciaRegionalId(),
                gerenciaNome: $entity->getGerenciaRegionalNome(),
                agenciaId: $entity->getAgenciaId(),
                agenciaNome: $entity->getAgenciaNome(),
                gerenteGestaoId: $entity->getGerenteGestaoId(),
                gerenteGestaoNome: $entity->getGerenteGestaoNome(),
                gerenteId: $entity->getGerenteId(),
                gerenteNome: $entity->getGerenteNome(),
                familiaId: $entity->getFamiliaId(),
                familiaNome: $entity->getFamiliaNome(),
                idIndicador: $entity->getIdIndicador(),
                dsIndicador: $entity->getDsIndicador(),
                subproduto: $entity->getSubindicador(),
                subindicadorCodigo: $entity->getIdSubindicador(),
                familiaCodigo: $entity->getFamiliaId(),
                indicadorCodigo: $entity->getIdIndicador(),
                carteira: $entity->getCarteira(),
                canalVenda: $entity->getCanalVenda(),
                tipoVenda: $entity->getTipoVenda(),
                modalidadePagamento: $entity->getModalidadePagamento(),
                data: $dataIso,
                competencia: $competenciaIso,
                metaMensal: RowMapper::toFloat($entity->getValorMeta()),
                realizadoMensal: RowMapper::toFloat($entity->getValorRealizado()),
                quantidade: RowMapper::toFloat($entity->getQuantidade()),
                peso: RowMapper::toFloat($entity->getPeso()),
                pontos: RowMapper::toFloat($entity->getPontos()),
                statusId: $entity->getStatusId(),
            );
            
            return $dto->toArray();
        }, $entities);
    }
}

