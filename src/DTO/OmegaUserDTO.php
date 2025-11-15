<?php

declare(strict_types=1);

namespace Pobj\Api\DTO;

final class OmegaUserDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $nome,
        public readonly ?string $funcional = null,
        public readonly ?string $matricula = null,
        public readonly ?string $cargo = null,
        public readonly bool $usuario = true,
        public readonly bool $analista = false,
        public readonly bool $supervisor = false,
        public readonly bool $admin = false,
        public readonly bool $encarteiramento = false,
        public readonly bool $meta = false,
        public readonly bool $orcamento = false,
        public readonly bool $pobj = false,
        public readonly bool $matriz = false,
        public readonly bool $outros = false,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'funcional' => $this->funcional,
            'matricula' => $this->matricula,
            'cargo' => $this->cargo,
            'usuario' => $this->usuario ? 1 : 0,
            'analista' => $this->analista ? 1 : 0,
            'supervisor' => $this->supervisor ? 1 : 0,
            'admin' => $this->admin ? 1 : 0,
            'encarteiramento' => $this->encarteiramento ? 1 : 0,
            'meta' => $this->meta ? 1 : 0,
            'orcamento' => $this->orcamento ? 1 : 0,
            'pobj' => $this->pobj ? 1 : 0,
            'matriz' => $this->matriz ? 1 : 0,
            'outros' => $this->outros ? 1 : 0,
        ];
    }
}

