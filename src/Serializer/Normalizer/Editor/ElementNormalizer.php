<?php

namespace App\Serializer\Normalizer\Editor;

use App\Entity\Editor\BaseElement;
use App\Model\Editor\ElementData;
use App\Serializer\Normalizer\AbstractObjectNormalizer;

class ElementNormalizer extends AbstractObjectNormalizer
{
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $normalized = $this->objectNormalizer->normalize($data, $format, $context);
        $normalized['data']['type'] = $normalized['type'];
        $normalized['data']['uuid'] = $normalized['uuid'];
        $normalized['data']['children'] = $normalized['children'];

        return $normalized['data'];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof BaseElement;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [BaseElement::class => true];
    }
}