<?php

namespace App\Model\Editor\Fixture;

use Symfony\Component\Serializer\Attribute\Groups;

#[Groups(['fixture'])]
final readonly class FixtureData
{
    public function __construct(

        public ?string $category = null,
        public ?string $name = null,
        public ?string $description = null,
        public array $tags = [],
    ) {}
}
