<?php

namespace App\Doctrine\Type;

use App\Attribute\Doctrine\JsonDocument;
use App\Component\Reader\AttributeReader;
use App\Services\ServiceTunnel;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonDocumentType extends JsonType
{
    public const NAME = 'json_document';

    private const FORMAT = 'json';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        assert(is_object($value), 'JsonDocument must be an object.');
        $attribute = AttributeReader::fromClass($value, JsonDocument::class, true);
        assert($attribute instanceof JsonDocument, 'JsonDocument attribute is missing.');

        return $this->serialize($value, $attribute);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (empty($value)) {
            return null;
        }

        assert(is_string($value), 'JsonDocument must be a string.');

        return $this->deserialize($value);
    }

    private function serialize(object $value, JsonDocument $definitions): string
    {
        $groups = $definitions->serializationGroups;
        $data = $this->getSerializer()->serialize($value, self::FORMAT, ['groups' => $groups]);

        return json_encode([
            '_type_' => get_class($value),
            '_groups_' => implode(',', $groups),
            '_data_' => json_decode($data, true),
        ]);
    }

    private function deserialize(string $value): object
    {
        $data = json_decode($value, true);

        assert(isset($data['_type_']), 'Class name is missing.');
        assert(isset($data['_groups_']), 'Groups are missing.');
        assert(isset($data['_data_']), 'Data is missing.');

        return $this->getSerializer()->deserialize(
            $data['_data_'],
            $data['_type_'],
            self::FORMAT,
            ['groups' => explode(',', $data['_groups_'])],
        );
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    private function getSerializer(): SerializerInterface
    {
        return ServiceTunnel::get(SerializerInterface::class);
    }
}
