<?php

declare(strict_types=1);

namespace Pobj\Api\Repositories;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Pobj\Api\DTO\CalendarioDTO;
use Pobj\Api\Helpers\DateFormatter;
use Pobj\Api\Interfaces\RepositoryInterface;

class CalendarioRepository implements RepositoryInterface
{
    private Connection $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function findAllAsArray(): array
    {
        $sql = "SELECT 
                    data,
                    ano,
                    mes,
                    mes_nome,
                    dia,
                    dia_da_semana,
                    semana,
                    trimestre,
                    semestre,
                    eh_dia_util
                FROM d_calendario
                ORDER BY data";
        
        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        return array_map(function ($row) {
            $dataIso = DateFormatter::toIsoDate($row['data'] ?? null);
            $ehDiaUtil = isset($row['eh_dia_util']) ? ($row['eh_dia_util'] ? 'Sim' : 'Não') : null;
            
            $dto = new CalendarioDTO(
                data: $dataIso,
                competencia: $dataIso,
                ano: $row['ano'] ?? null,
                mes: $row['mes'] ?? null,
                mesNome: $row['mes_nome'] ?? null,
                dia: $row['dia'] ?? null,
                diaDaSemana: $row['dia_da_semana'] ?? null,
                semana: $row['semana'] ?? null,
                trimestre: $row['trimestre'] ?? null,
                semestre: $row['semestre'] ?? null,
                ehDiaUtil: $ehDiaUtil,
            );
            
            return $dto->toArray();
        }, $results);
    }
}

