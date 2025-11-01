<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CoreExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('env', $this->getEnv(...), ['is_safe' => ['html']]),
        ];
    }

    public function getEnv(string $string, string $default = ''): string
    {
        return $_ENV[$string] ?? $default;
    }
}
