<?php

namespace App\Traits\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait UpdatedTrait
{
    #[ORM\Column]
    private ?DateTimeImmutable $updated = null;

    #[Groups(['app'])]
    public function getUpdated(): ?DateTimeImmutable
    {
        return $this->updated;
    }

    #[ORM\PrePersist]
    public function setUpdated(): static
    {
        $this->updated = new DateTimeImmutable();

        return $this;
    }
}
