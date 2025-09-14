<?php

namespace App\Traits\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait CreatedTrait
{
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $created = null;

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
