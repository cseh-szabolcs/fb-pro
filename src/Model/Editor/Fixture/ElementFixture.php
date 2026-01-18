<?php

namespace App\Model\Editor\Fixture;

use App\Model\Editor\ElementData;
use Symfony\Component\Uid\Uuid;

final readonly class ElementFixture
{
    public Uuid $uuid;

    public function __construct(
        public ElementData $data,
        protected array $children = [],
        protected ?ElementFixture $parent = null,
    ) {
        $this->uuid = Uuid::v7();
    }

    public function getType(): string
    {
        return $this->data->getType();
    }
}
