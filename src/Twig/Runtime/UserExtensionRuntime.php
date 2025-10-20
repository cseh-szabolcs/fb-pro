<?php

namespace App\Twig\Runtime;

use App\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

final readonly class UserExtensionRuntime implements RuntimeExtensionInterface
{
    public function getUsername(User $user): string
    {
        if ($name = $user->getName()) {
            return $name;
        }

        return 'User';
    }
}
