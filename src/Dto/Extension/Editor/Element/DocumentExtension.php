<?php

namespace App\Dto\Extension\Editor\Element;

use App\Entity\Editor\Element\PageElement;
use App\Model\Editor\ElementData\DocumentData;

class DocumentExtension extends AbstractExtension
{
    public static function supports(object $data, array $context = []): bool
    {
        return $data instanceof DocumentData;
    }

    protected function supportedTypes(): array
    {
        return [
            PageElement::TYPE,
        ];
    }
}
