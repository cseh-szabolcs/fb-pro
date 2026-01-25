<?php

namespace App\Dto\Extension\Editor\Element;

use App\Entity\Editor\Element\InputElement;
use App\Entity\Editor\Element\PageElement;
use App\Entity\Editor\Element\ViewElement;

class FieldsetExtension extends AbstractExtension
{
    public static function supports(object $subject, array $context = []): bool
    {
        return $subject instanceof PageElement;
    }

    protected function supportedTypes(): array
    {
        return [
            ViewElement::TYPE,
            InputElement::TYPE,
        ];
    }
}
