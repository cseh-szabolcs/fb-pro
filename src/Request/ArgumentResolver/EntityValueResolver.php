<?php

namespace App\Request\ArgumentResolver;

use App\Attribute\ArgumentResolver\MapEntity;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver as DecoratedEntityValueResolver;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Decorates doctrines entity-resolver to allow deep-nested deserialization (with arrays) on existing entities
 * or to create new entity-instances by using our custom map-entity-attribute.
 */
#[AsDecorator(decorates: 'doctrine.orm.entity_value_resolver')]
readonly class EntityValueResolver implements ValueResolverInterface
{
    private const NORMALIZATION_GROUPS = ['api', 'api-write'];

    public function __construct(
        #[AutowireDecorated]
        private DecoratedEntityValueResolver $decorated,
        private SerializerInterface $serializer,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $attributes = $argument->getAttributes();

        if (count($attributes)
            && $request->isMethod('POST')
            && $request->getContentTypeFormat() === 'json'
            && $content = $request->getContent()
        ) {
            return $this->handleDeserialization($request, $argument, $content, $attributes);
        }

        return $this->decorated->resolve($request, $argument);
    }

    private function handleDeserialization(Request $request, ArgumentMetadata $argument, string $content, array $attributes): array
    {
        if ($this->shouldCreateNew($attributes)) {
            return [
                $this->serializer->deserialize($content, $argument->getType(), 'json', [
                    AbstractNormalizer::GROUPS => self::NORMALIZATION_GROUPS,
                ]),
            ];
        }

        $result = $this->decorated->resolve($request, $argument);
        foreach ($result as $entity) {
            $this->serializer->deserialize($content, get_class($entity), 'json', [
                AbstractNormalizer::GROUPS => self::NORMALIZATION_GROUPS,
                AbstractNormalizer::OBJECT_TO_POPULATE => $entity,
            ]);
        }

        return $result;
    }

    private function shouldCreateNew(array $attributes): bool
    {
        foreach ($attributes as $attribute) {
            if (get_class($attribute) === MapEntity::class) {
                return $attribute->new;
            }
        }
        return false;
    }
}
