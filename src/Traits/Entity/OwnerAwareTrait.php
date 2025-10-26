<?php

namespace App\Traits\Entity;

use App\Entity\Mandate;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait OwnerAwareTrait
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $owner;

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getMandate(): Mandate
    {
        return $this->owner->getMandate();
    }
}
