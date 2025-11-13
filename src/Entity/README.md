# Entidades Doctrine

Este diretório contém as entidades (models) do Doctrine ORM.

## Exemplo de Entidade

```php
<?php

declare(strict_types=1);

namespace Pobj\Api\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'omega_usuarios')]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nome;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $email;

    // Getters e Setters...
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
```

## Uso no Handler

```php
use Pobj\Api\Database\DoctrineManager;
use Pobj\Api\Entity\Usuario;

$em = DoctrineManager::getEntityManager();

// Buscar
$usuario = $em->find(Usuario::class, 1);

// Query Builder
$usuarios = $em->getRepository(Usuario::class)
    ->createQueryBuilder('u')
    ->where('u.email = :email')
    ->setParameter('email', 'exemplo@email.com')
    ->getQuery()
    ->getResult();

// Persistir
$novoUsuario = new Usuario();
$novoUsuario->setNome('João');
$novoUsuario->setEmail('joao@email.com');
$em->persist($novoUsuario);
$em->flush();
```

