<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\UserExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class UserExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // parameter: ['is_safe' => ['html']]
            new TwigFilter('username', [UserExtensionRuntime::class, 'getUsername']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('username', [UserExtensionRuntime::class, 'getUsername']),
        ];
    }
}
