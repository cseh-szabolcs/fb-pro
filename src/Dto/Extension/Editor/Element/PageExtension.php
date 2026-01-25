<?php

namespace App\Dto\Extension\Editor\Element;

use App\Entity\Editor\Element\ViewElement;
use App\Model\Editor\ElementData\PageData;

class PageExtension extends AbstractExtension
{
    public static function supports(object $data, array $context = []): bool
    {
        return $data instanceof PageData;
    }

    protected function supportedTypes(): array
    {
        return [
            ViewElement::TYPE,
        ];
    }
}
