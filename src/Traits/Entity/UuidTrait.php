<?php

declare(strict_types=1);

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use function assert;

trait UuidTrait
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUuid(): Uuid
    {
        assert($this->id);

        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        assert(empty($this->id));
        $this->id = $id;

        return $this;
    }
}
