<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'd_mapa_unidade')]
class DMapaUnidade
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 2)]
    private string $tipo;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 10)]
    private string $codigo;

    #[ORM\Column(name: 'id_destino', type: 'integer')]
    private int $idDestino;

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function getIdDestino(): int
    {
        return $this->idDestino;
    }

    public function setIdDestino(int $idDestino): self
    {
        $this->idDestino = $idDestino;
        return $this;
    }
}

