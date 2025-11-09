<?php

namespace App\Model\Editor;

use App\Attribute\Doctrine\JsonDocument;
use App\Model\Editor\Data\DocumentData;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap as SerializerMap;
use Symfony\Component\Serializer\Attribute\Groups;

#[SerializerMap(typeProperty: 'type', mapping: self::TYPES)]
#[JsonDocument(serializationGroups: ['editor'])]
abstract class BaseData
{
    const TYPES = [
        DocumentData::TYPE => DocumentData::class,
    ];

    const TYPE = 'base';

    public ?string $etag = null;

    #[Groups(['editor'])]
    public ?string $backgroundColor = null;

    #[Groups(['editor'])]
    public ?string $textColor = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function getType(): string
    {
        return static::TYPE;
    }
}
