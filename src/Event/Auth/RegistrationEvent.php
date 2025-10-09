<?php

namespace App\Event\Auth;

use App\Entity\Token;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

final class RegistrationEvent extends Event
{
    public function __construct(
        public readonly User $user,
        public readonly Token $token,
    ) {}
}
