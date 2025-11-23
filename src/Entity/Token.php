<?php

namespace App\Entity;

use App\Contracts\OwnerAwareInterface;
use App\Repository\TokenRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\OwnerAwareTrait;
use App\Traits\Entity\UuidTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token implements OwnerAwareInterface
{
    use UuidTrait;
    use OwnerAwareTrait;
    use CreatedTrait;

    const TYPE_AUTH = 'auth';
    const TYPE_REGISTRATION = 'registration';
    const TYPE_PASSWORD_RESET = 'password_reset';

    #[ORM\Column(length: 50, index: true)]
    private ?string $type;

    #[ORM\Column(nullable: true)]
    private ?array $payload;

    #[ORM\Column]
    private ?bool $renewable;

    #[ORM\Column(nullable: true)]
    private ?int $ttl;

    public function __construct(
        User $owner,
        string $type,
        ?array $payload = null,
        ?int $ttl = null,
        bool $renewable = false,
    ) {
        $this->owner = $owner;
        $this->type = $type;
        $this->payload = $payload;
        $this->ttl = $ttl;
        $this->renewable = $renewable;
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

    public function isRenewable(): ?bool
    {
        return $this->renewable;
    }

    public function isExpired(?int $ttl = null): bool
    {
        $ttl = $ttl ?? $this->ttl;

        return null !== $ttl && $this->created->getTimestamp() + $ttl < time();
    }

    public function __clone()
    {
        $this->id = null;
        $this->created = null;
        $this->setCreated();
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
