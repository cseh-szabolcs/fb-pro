<?php

namespace App\Dto\Extension\Editor\Element;

use App\Entity\Editor\Element\InputElement;
use App\Entity\Editor\Element\ViewElement;
use App\Model\Editor\ElementData\FieldsetData;
use App\Model\Editor\ElementData\ViewData;

class ViewExtension extends AbstractExtension
{
    public static function supports(object $data, array $context = []): bool
    {
        return $data instanceof ViewData;
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
