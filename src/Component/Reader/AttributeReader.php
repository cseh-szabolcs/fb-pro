<?php

namespace App\Component\Reader;

use App\Security\Attribute\GuestGranted;
use App\Traits\Pattern\StaticTrait;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

final readonly class AttributeReader
{
    use StaticTrait;

    /**
     * @template T of object
     * @param class-string<T> $attribute
     * @return T|null
     * @throws ReflectionException
     */
    public static function fromMethod(object|string $object, string $method, string $attribute): ?object
    {
        $refMethod = new ReflectionMethod($object, $method);
        $attr = $refMethod->getAttributes(GuestGranted::class)[0] ?? null;

        if (!$attr) {
            $refClass = new ReflectionClass($object);
            $attr = $refClass->getAttributes($attribute)[0] ?? null;
        }

        if (!$attr) {
            return null;
        }

        return $attr->newInstance();
    }
}
