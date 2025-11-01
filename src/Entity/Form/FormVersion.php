<?php

namespace App\Entity\Form;

use App\Entity\Form;
use App\Repository\Form\FormVersionRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\UpdatedTrait;
use App\Traits\Entity\UuidAwareTrait;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: FormVersionRepository::class)]
#[ORM\Index(name: 'uuid_idx', columns: ['uuid'])]
#[ORM\HasLifecycleCallbacks]
class FormVersion
{
    use UuidAwareTrait;
    use UpdatedTrait;
    use CreatedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Form $form;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $published = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getForm(): ?Form
    {
        return $this->form;
    }

    public function setForm(?Form $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function isPublished(): bool
    {
        return null !== $this->published;
    }

    #[Groups(['default'])]
    public function getPublished(): ?DateTimeImmutable
    {
        return $this->published;
    }

    public function publish(): self
    {
        if (null === $this->form && $this->id !== $this->form->getDraftVersion()->getId()) {
            $this->published = new DateTimeImmutable();
            $this->form->setPublished($this);
        }

        return $this;
    }
}
