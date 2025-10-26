<?php

namespace App\Component\Reader;

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
        $attr = $refMethod->getAttributes($attribute)[0] ?? null;

        if (!$attr) {
            return self::fromClass($object, $attribute);
        }

        return $attr->newInstance();
    }

    /**
     * @template T of object
     * @param class-string<T> $attribute
     * @return T|null
     * @throws ReflectionException
     */
    public static function fromClass(object|string $object, string $attribute): ?object
    {
        $refClass = new ReflectionClass($object);
        $attr = $refClass->getAttributes($attribute)[0] ?? null;

        return $attr?->newInstance();
    }
}
