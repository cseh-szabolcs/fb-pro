<?php

namespace App\Dto\Extension\Editor\Element;

use App\Entity\Editor\Element\PageElement;
use App\Entity\Editor\Element\ViewElement;

class PageExtension extends AbstractExtension
{
    public static function supports(object $subject, array $context = []): bool
    {
        return $subject instanceof PageElement;
    }

    protected function supportedTypes(): array
    {
        return [
            ViewElement::TYPE,
        ];
    }
}
