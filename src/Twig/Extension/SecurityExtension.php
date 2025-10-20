<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\SecurityExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SecurityExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_auth', [SecurityExtensionRuntime::class, 'isAuthenticated']),
            new TwigFunction('is_guest', [SecurityExtensionRuntime::class, 'isGuest']),
        ];
    }
}
