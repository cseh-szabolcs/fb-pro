<?php

namespace App\Model\Editor\ElementData;

use App\Attribute\Doctrine\JsonDocument;
use App\Model\Editor\ElementData\Props\Corner;
use App\Model\Editor\ElementData\Props\Side;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap as SerializerMap;
use Symfony\Component\Serializer\Attribute\Groups;

#[SerializerMap(typeProperty: 'type', mapping: self::TYPES)]
#[JsonDocument(serializationGroups: ['editor'])]
abstract class BaseData
{
    const TYPES = [
        DocumentData::TYPE => DocumentData::class,
        FieldsetData::TYPE => FieldsetData::class,
        PageData::TYPE => PageData::class,
        ViewData::TYPE => ViewData::class,
        InputData::TYPE=> InputData::class,
    ];

    const TYPE = 'base';

    public ?string $etag = null;

    #[Groups(['editor'])]
    public ?string $role = null;

    #[Groups(['editor'])]
    public ?string $backgroundColor = null;

    #[Groups(['editor'])]
    public ?string $color = null;

    #[Groups(['editor'])]
    public ?bool $directionRow = null;

    #[Groups(['editor'])]
    public ?Side $margin = null;

    #[Groups(['editor'])]
    public ?Side $padding = null;

    #[Groups(['editor'])]
    public ?Side $borderWidth = null;

    #[Groups(['editor'])]
    public ?Side $borderColor = null;

    #[Groups(['editor'])]
    public ?Corner $borderRadius = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getType(): string
    {
        return static::TYPE;
    }
}
