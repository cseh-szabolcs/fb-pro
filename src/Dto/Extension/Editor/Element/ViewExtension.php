<?php

namespace App\Dto\Extension\Editor\Element;

use App\Entity\Editor\Element\InputElement;
use App\Entity\Editor\Element\PageElement;
use App\Entity\Editor\Element\ViewElement;
use App\Model\Editor\ElementData\FieldsetData;

class ViewExtension extends AbstractExtension
{
    public static function supports(object $subject, array $context = []): bool
    {
        return $subject instanceof PageElement;
    }

    protected function supportedTypes(): array
    {
        return [
            ViewElement::TYPE,
            FieldsetData::TYPE,
            InputElement::TYPE,
        ];
    }
}
