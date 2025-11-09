<?php

namespace App\Traits\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait CreatedTrait
{
    #[ORM\Column]
    private ?DateTimeImmutable $created = null;

    #[Groups(['app', 'editor'])]
    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    #[ORM\PrePersist]
    public function setCreated(): void
    {
        if (null === $this->created) {
            $this->created = new DateTimeImmutable();
        }
    }
}
