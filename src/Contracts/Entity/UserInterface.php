<?php

namespace App\Contracts\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends
    BaseUserInterface,
    PasswordAuthenticatedUserInterface,
    UuidAwareInterface
{}
