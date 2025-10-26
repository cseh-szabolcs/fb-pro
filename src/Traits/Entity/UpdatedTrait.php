<?php

namespace App\Traits\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait UpdatedTrait
{
    #[ORM\Column]
    private ?DateTimeImmutable $updated = null;

    public function getUpdated(): ?DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeImmutable $updated): static
    {
        $this->updated = $updated;

        return $this;
    }
}
