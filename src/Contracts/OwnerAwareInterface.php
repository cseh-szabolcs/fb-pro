<?php

namespace App\Contracts;

use App\Entity\User;

interface OwnerAwareInterface extends MandateAwareInterface
{
    public function getOwner(): User;
}
