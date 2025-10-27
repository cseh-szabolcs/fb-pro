<?php

namespace App\Twig\Components\Html;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Modal
{
    public string $label;
    public string $id;
    public ?string $title = null;
    public ?string $action = 'Submit';
    public ?string $size = null;
}
