<?php

namespace App\Entity;

use App\Contracts\MandateAwareInterface;
use App\Contracts\OwnerAwareInterface;
use App\Entity\Form\FormVersion;
use App\Repository\FormRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\MandateAwareTrait;
use App\Traits\Entity\OwnerAwareTrait;
use App\Traits\Entity\UuidAwareTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: FormRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Form implements MandateAwareInterface, OwnerAwareInterface
{
    use UuidAwareTrait;
    use MandateAwareTrait;
    use OwnerAwareTrait;
    use CreatedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mandate $mandate = null;

    #[ORM\Column(length: 255)]
    private ?string $title;

    #[ORM\Column(length: 255)]
    private ?string $description;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?FormVersion $draftVersion = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?FormVersion $publishedVersion = null;

    #[ORM\OneToMany(targetEntity: FormVersion::class, mappedBy: 'form', cascade: ['remove', 'persist', 'refresh', 'detach'], orphanRemoval: true)]
    #[ORM\OrderBy(['updated' => 'DESC'])]
    private Collection $versions;

    public function __construct(User $user, string $title, FormVersion $draftVersion, string $description = null)
    {
        $this->owner = $user;
        $this->title = $title;
        $this->description = $description;
        $this->versions = new ArrayCollection();
        $this->setDraftVersion($draftVersion);
        $this->setMandate($user);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['app'])]
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    #[Groups(['app'])]
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    #[Groups(['app'])]
    public function getDraftVersion(): FormVersion
    {
        assert($this->draftVersion instanceof FormVersion);

        return $this->draftVersion;
    }

    public function setDraftVersion(FormVersion $draftVersion): static
    {
        if (null === $this->draftVersion) {
            $this->draftVersion = $draftVersion;
            $draftVersion->setForm($this);
        }

        return $this;
    }

    #[Groups(['app'])]
    public function getPublishedVersion(): ?FormVersion
    {
        return $this->publishedVersion;
    }

    public function setPublished(?FormVersion $publishedVersion): static
    {
        $this->publishedVersion = $publishedVersion;
        $this->versions->add($publishedVersion);

        return $this;
    }

    public function isPublished(): bool
    {
        return null !== $this->publishedVersion;
    }


    /** @return  Collection<int, FormVersion> */
    public function getVersions(): Collection
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->neq('published', null))
            ->orderBy(['published' => Order::Descending]);

        return $this->versions->matching($criteria);
    }

    #[Groups(['app'])]
    public function getLastEdited(): ?DateTimeInterface
    {
        return $this->draftVersion->getUpdated();
    }
}
