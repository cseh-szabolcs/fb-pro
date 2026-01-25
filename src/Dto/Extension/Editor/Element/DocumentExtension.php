<?php

namespace App\Dto\Extension\Editor\Element;

use App\Entity\Editor\Element\DocumentElement;
use App\Entity\Editor\Element\PageElement;

class DocumentExtension extends AbstractExtension
{
    public static function supports(object $subject, array $context = []): bool
    {
        return $subject instanceof DocumentElement;
    }

    protected function supportedTypes(): array
    {
        return [
            PageElement::TYPE,
        ];
    }
}
