<?php

namespace App\Contracts;

use App\Entity\User;

interface OwnerAwareInterface
{
    public function getOwner(): User;
}
