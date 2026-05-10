<?php

namespace App\Model\Editor\Fixture;

use App\Contracts\Editor\ElementDataAwareInterface;
use App\Model\Editor\ElementData\BaseData;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[Groups(['fixture'])]
final readonly class FixtureElement implements ElementDataAwareInterface
{
    public Uuid $id;

    public function __construct(
        public BaseData $data,
        public int $position = 0,
        public array $children = [],
        protected ?FixtureElement $parent = null,
        public ?FixtureData $fixtureData = null,
    ) {
        $this->id = Uuid::v7();
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
