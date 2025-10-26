<?php

namespace App\Attribute\Doctrine;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class JsonDocument {
    public function __construct(
        public array $serializationGroups = []
    ) {
    }
}
