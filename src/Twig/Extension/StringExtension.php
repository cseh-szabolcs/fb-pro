<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\SecurityExtensionRuntime;
use App\Twig\Runtime\UserExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class StringExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('kebab_case', $this->kebabCase(...), ['is_safe' => ['html']]),
        ];
    }

    public function kebabCase(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $string));
    }
}
