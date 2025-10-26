<?php

namespace App\Entity;

use App\Contracts\MandateAwareInterface;
use App\Entity\Form\FormVersion;
use App\Repository\FormRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\MandateAwareTrait;
use App\Traits\Entity\UpdatedTrait;
use App\Traits\Entity\UuidAwareTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormRepository::class)]
#[ORM\Index(name: 'uuid_idx', columns: ['uuid'])]
class Form implements MandateAwareInterface
{
    use UuidAwareTrait;
    use MandateAwareTrait;
    use UpdatedTrait;
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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?FormVersion $draft = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?FormVersion $published = null;

    #[ORM\OneToMany(targetEntity: FormVersion::class, mappedBy: 'form', cascade: ['all'], orphanRemoval: true)]
    private Collection $versions;

    public function __construct(Mandate|User $mandate, string $title)
    {
        $this->setMandate($mandate);
        $this->title = $title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDraft(): ?FormVersion
    {
        return $this->draft;
    }

    public function setDraft(FormVersion $draft): static
    {
        $this->draft = $draft;

        return $this;
    }

    public function getPublished(): ?FormVersion
    {
        return $this->published;
    }

    public function setPublished(?FormVersion $published): static
    {
        $this->published = $published;
        $this->versions->add($published);

        return $this;
    }

    public function isPublished(): bool
    {
        return null !== $this->published;
    }

    public function areChangesPublied(): bool
    {
        return $this->draft->getId() && !$this->getId();
    }

    /** @return  Collection<int, FormVersion> */
    public function getVersions(): Collection
    {
        return $this->versions;
    }
}
