<?php

namespace App\Contracts;

use App\Entity\Mandate;

interface MandateAwareInterface
{
    public function getMandate(): Mandate;
}
