<?php

namespace App\Traits\Entity;

use App\Entity\Mandate;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait MandateAwareTrait
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mandate $mandate = null;

    public function getMandate(): Mandate
    {
        return $this->mandate;
    }

    public function setMandate(Mandate|User $mandate): static
    {
        $this->mandate = $mandate instanceof User
            ? $mandate->getMandate()
            : $mandate;

        return $this;
    }
}
