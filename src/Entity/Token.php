<?php

namespace App\Entity;

use App\Contracts\OwnerAwareInterface;
use App\Repository\TokenRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\OwnerAwareTrait;
use App\Traits\Entity\UuidTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
#[ORM\Index(name: 'name_idx', columns: ['name'])]
class Token implements OwnerAwareInterface
{
    use UuidTrait;
    use OwnerAwareTrait;
    use CreatedTrait;

    const PASSWORD_RESET_KEY = 'password_reset';

    #[ORM\Column(length: 50)]
    private ?string $name;

    #[ORM\Column(nullable: true)]
    private ?array $payload;

    #[ORM\Column(nullable: true)]
    private ?int $ttl;

    public function __construct(User $owner, string $name, ?array $payload = null, ?int $ttl = null)
    {
        $this->owner = $owner;
        $this->name = $name;
        $this->payload = $payload;
        $this->ttl = $ttl;
        $this->setCreated();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPayload(?string $key = null, mixed $default = null): mixed
    {
        if (null === $this->payload) {
            return $default;
        }

        return $key
            ? $this->payload[$key]
            : $this->payload;
    }

    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    public function isExpired(): bool
    {
        return null !== $this->ttl && $this->created->getTimestamp() + $this->ttl < time();
    }
}
