<?php

namespace App\Entity;

use App\Constants\Lang;
use App\Constants\Role;
use App\Contracts\Entity\UserInterface;
use App\Repository\UserRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\UuidAwareTrait;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\Index(name: 'uuid_idx', columns: ['uuid'])]
#[ORM\Index(name: 'email_idx', columns: ['email'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface
{
    use UuidAwareTrait;
    use CreatedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mandate $mandate;

    #[ORM\Column(length: 255)]
    private ?string $email;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    public ?string $passwordPlain = null;

    #[ORM\Column(length: 255)]
    private ?string $role;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $locale;

    #[ORM\Column]
    private ?bool $termsAgreed;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $confirmedAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $lastAccess;

    public function __construct(
        Mandate $mandate,
        string $email,
        string $role = Role::NEW->value,
        ?string $locale = null,
        ?bool $termsAgreed = false,
    ) {
        $this->mandate = $mandate;
        $this->email = $email;
        $this->role = $role;
        $this->locale = $locale ?? Lang::getDefault();
        $this->termsAgreed = $termsAgreed;
        $this->confirmedAt = new DateTimeImmutable();
        $this->lastAccess = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMandate(): ?Mandate
    {
        return $this->mandate;
    }

    public function setMandate(?Mandate $mandate): static
    {
        $this->mandate = $mandate;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function eraseCredentials(): void
    {
        $this->passwordPlain = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLastAccess(): DateTimeImmutable
    {
        return $this->lastAccess;
    }

    public function refreshLastAccess(): static
    {
        $this->lastAccess = new DateTimeImmutable();

        return $this;
    }

    public function getAuthSignature(): ?string
    {
        return sha1(sprintf(
            '%s:%s:%d',
            $this->email,
            $this->password,
            $this->mandate->getId(),
        ));
    }
}
