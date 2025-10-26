<?php

namespace App\Entity;

use App\Repository\FormRepository;
use App\Traits\Entity\CreatedTrait;
use App\Traits\Entity\MandateAwareTrait;
use App\Traits\Entity\UpdatedTrait;
use App\Traits\Entity\UuidAwareTrait;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: FormRepository::class)]
class Form
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

    public function __construct(Mandate|User $mandate)
    {
        $this->generateUuid();
        $this->setMandate($mandate);
        $this->created = new DateTimeImmutable();
        $this->updated = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
