<?php

namespace App\Event\Auth;

use App\Entity\Token;
use Symfony\Contracts\EventDispatcher\Event;

final class PasswordResetEvent extends Event
{
    public function __construct(
        public readonly Token $token,
    ) {}
}
