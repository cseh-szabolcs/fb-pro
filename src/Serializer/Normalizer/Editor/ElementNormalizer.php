<?php

namespace App\Serializer\Normalizer\Editor;

use App\Contracts\Editor\ElementDataAwareInterface;
use App\Contracts\OutputExtensionInterface;
use App\Entity\Editor\Element\BaseElement;
use App\Model\Editor\Fixture\FixtureElement;
use App\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final class ElementNormalizer extends AbstractObjectNormalizer
{
    public function __construct(
        /** @var callable():OutputExtensionInterface[] */
        #[AutowireIterator(tag: 'app.dto_extension.editor.element')]
        private readonly iterable $extensions,
    ) {}

    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        /** @var BaseElement $data */
        $normalized = $this->objectNormalizer->normalize($data, $format, $context);
        $normalized['data']['uuid'] = $normalized['uuid'];
        $normalized['data']['type'] = $normalized['type'];
        $normalized['data']['position'] = $normalized['position'];
        $normalized['data']['children'] = $normalized['children'];

        if ($data instanceof FixtureElement) {
            $normalized['data']['fixtureData'] = $normalized['fixtureData'];
        }

        /** @var OutputExtensionInterface $extension */
        foreach ($this->extensions as $extension) {
            if ($extension::supports($data->getData(), $context)) {
                $normalized['data'] = [
                    ...$normalized['data'],
                    ...$this->objectNormalizer->normalize($extension, $format, $context),
                ];
            }
        }

        return $normalized['data'];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ElementDataAwareInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            BaseElement::class => true,
            FixtureElement::class => true,
        ];
    }
}
