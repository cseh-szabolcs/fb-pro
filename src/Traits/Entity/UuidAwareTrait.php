<?php

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

trait UuidAwareTrait
{
    #[ORM\Column(type: UuidType::NAME, unique: true, index: true)]
    private ?Uuid $uuid = null;

    #[Groups(['app'])]
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    #[ORM\PrePersist]
    public function generateUuid(): void
    {
        if (null === $this->uuid) {
            $this->uuid = Uuid::v4();
        }
    }
}
