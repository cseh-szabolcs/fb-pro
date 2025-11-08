<?php

namespace App\Model\Editor;

use App\Attribute\Doctrine\JsonDocument;
use Symfony\Component\Serializer\Attribute\Groups;

#[JsonDocument(serializationGroups: ['api'])]
abstract class BaseData
{
    #[Groups(['api'])]
    public ?string $backgroundColor = null;

    #[Groups(['api'])]
    public ?string $textColor = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
