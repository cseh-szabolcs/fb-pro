<?php

namespace App\Model\Editor;

use App\Attribute\Doctrine\JsonDocument;

#[JsonDocument(serializationGroups: ['api'])]
abstract class BaseData
{
    public ?string $backgroundColor = null;
    public ?string $textColor = null;
}
