<?php

namespace App\Attribute\ArgumentResolver;

use Attribute;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver;
use Symfony\Bridge\Doctrine\Attribute\MapEntity as BaseMapEntity;

/**
 * Extends doctrines map-entity by creating a new plain object, when no entity found.
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class MapEntity extends BaseMapEntity
{
    public function __construct(
        public ?bool $new = false,
        public ?string $class = null,
        public ?string $objectManager = null,
        public ?string $expr = null,
        public ?array $mapping = null,
        public ?array $exclude = null,
        public ?bool $stripNull = null,
        public array|string|null $id = null,
        public ?bool $evictCache = null,
        bool $disabled = false,
        string $resolver = EntityValueResolver::class,
    ) {
        parent::__construct(
            $class,
            $objectManager,
            $expr,
            $mapping,
            $exclude,
            $stripNull,
            $id,
            $evictCache,
            $disabled,
            $resolver,
        );
    }
}
