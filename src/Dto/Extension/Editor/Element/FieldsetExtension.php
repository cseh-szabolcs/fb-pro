<?php

namespace App\Dto\Extension\Editor\Element;

use App\Entity\Editor\Element\InputElement;
use App\Entity\Editor\Element\ViewElement;
use App\Model\Editor\ElementData\FieldsetData;

class FieldsetExtension extends AbstractExtension
{
    public static function supports(object $data, array $context = []): bool
    {
        return $data instanceof FieldsetData;
    }

    protected function supportedTypes(): array
    {
        return [
            ViewElement::TYPE,
            InputElement::TYPE,
        ];
    }
}
