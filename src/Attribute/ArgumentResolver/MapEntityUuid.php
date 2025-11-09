<?php

namespace App\Attribute\ArgumentResolver;

use Attribute;

/**
 * Extends doctrines map-entity by creating a new plain object, when no entity found.
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class MapEntityUuid extends MapEntity
{
    public function __construct(
        array $mapping = ['uuid' => 'uuid'],
    ) {
        parent::__construct(mapping: $mapping);
    }
}
