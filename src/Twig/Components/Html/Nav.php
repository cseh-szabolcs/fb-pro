<?php

namespace App\Twig\Components\Html;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Nav
{
    /** @var Nav\Item[] */
    public array $items;

    public string $background = 'bg-app';
}
