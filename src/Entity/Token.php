<?php

namespace App\Entity;

use App\Contracts\OwnerAwareInterface;
use App\Repository\TokenRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\OwnerAwareTrait;
use App\Traits\Entity\UuidTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
#[ORM\Index(name: 'type_idx', columns: ['type'])]
class Token implements OwnerAwareInterface
{
    use UuidTrait;
    use OwnerAwareTrait;
    use CreatedTrait;

    const TYPE_REGISTRATION = 'registration';
    const TYPE_PASSWORD_RESET = 'password_reset';

    #[ORM\Column(length: 50)]
    private ?string $type;

    #[ORM\Column(nullable: true)]
    private ?array $payload;

    #[ORM\Column(nullable: true)]
    private ?int $ttl;

    public function __construct(User $owner, string $type, ?array $payload = null, ?int $ttl = null)
    {
        $this->owner = $owner;
        $this->type = $type;
        $this->payload = $payload;
        $this->ttl = $ttl;
        $this->setCreated();
    }

    public function getType(): string
    {
        return $this->type;
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

    public function setTtl(?int $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function isExpired(): bool
    {
        return null !== $this->ttl && $this->created->getTimestamp() + $this->ttl < time();
    }

    public function isOk(): bool
    {
        return !$this->isExpired();
    }
}
