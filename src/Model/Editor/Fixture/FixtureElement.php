<?php

namespace App\Model\Editor\Fixture;

use App\Contracts\Editor\ElementDataAwareInterface;
use App\Model\Editor\ElementData\BaseData;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[Groups(['fixture'])]
final readonly class FixtureElement implements ElementDataAwareInterface
{
    public Uuid $uuid;

    public function __construct(
        public BaseData $data,
        public FixtureData $fixtureData,
        public int $position = 0,
        public array $children = [],
        protected ?FixtureElement $parent = null,
    ) {
        $this->uuid = Uuid::v7();
    }

    public function getData(): BaseData
    {
        return $this->data;
    }

    #[Groups(['fixture'])]
    public function getType(): string
    {
        return $this->data->getType();
    }
}
