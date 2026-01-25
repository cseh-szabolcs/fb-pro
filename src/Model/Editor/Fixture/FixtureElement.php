<?php

namespace App\Model\Editor\Fixture;

use App\Contracts\Editor\ElementDataAwareInterface;
use App\Model\Editor\ElementData\BaseData;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

final readonly class FixtureElement implements ElementDataAwareInterface
{
    #[Groups(['fixture'])]
    public Uuid $uuid;

    public function __construct(
        #[Groups(['fixture'])]
        public BaseData $data,

        #[Groups(['fixture'])]
        public int $position = 0,

        #[Groups(['fixture'])]
        public array $children = [],

        #[Groups(['fixture'])]
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
