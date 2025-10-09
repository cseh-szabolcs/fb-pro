<?php

namespace App\Event\Auth;

use App\Entity\Token;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

final class PasswordResetRequestEvent extends Event
{
    public function __construct(
        public readonly Token $token,
        public readonly User $user,
    ) {}
}
