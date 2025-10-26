<?php

namespace App\Component;

use App\Entity\Mandate;
use App\Entity\User;
use App\Traits\Pattern\StaticTrait;

class MandateGet
{
    use StaticTrait;

    public static function get(User|Mandate $subject): Mandate
    {
        return $subject instanceof User
            ? $subject->getMandate()
            : $subject;
    }
}
