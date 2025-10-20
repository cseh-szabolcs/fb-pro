<?php

namespace App\Entity;

use App\Constants\Role;
use App\Contracts\Entity\UuidAwareInterface;
use App\Repository\MandateRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\UuidAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MandateRepository::class)]
#[ORM\Index(name: 'uuid_idx', columns: ['uuid'])]
#[ORM\HasLifecycleCallbacks]
class Mandate implements UuidAwareInterface
{
    use UuidAwareTrait;
    use CreatedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $owner;

    #[ORM\Column(length: 255)]
    private ?string $name;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'mandate', orphanRemoval: true)]
    private Collection $users;

    public function __construct(string $name, User $owner = null)
    {
        $this->name = $name;
        $this->owner = $owner;
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;
        if ($owner && $owner->getRole() === Role::USER) {
            $owner->setRole(Role::MANDANT);
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setMandate($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getMandate() === $this) {
                $user->setMandate(null);
            }
        }

        return $this;
    }
}
