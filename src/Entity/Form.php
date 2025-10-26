<?php

namespace App\Entity;

use App\Contracts\MandateAwareInterface;
use App\Repository\FormRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\MandateAwareTrait;
use App\Traits\Entity\UpdatedTrait;
use App\Traits\Entity\UuidAwareTrait;
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
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mandate $mandate = null;

    #[ORM\Column(length: 255)]
    private ?string $title;

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
}
