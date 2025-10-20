<?php

namespace App\Twig\Runtime;

use App\Security\AuthProvider;
use Twig\Extension\RuntimeExtensionInterface;

final readonly class SecurityExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private AuthProvider $authProvider,
    ) {}

    public function isAuthenticated(): bool
    {
        return $this->authProvider->isAuthenticated();
    }

    public function isGuest(): bool
    {
        return !$this->authProvider->isAuthenticated();
    }
}
