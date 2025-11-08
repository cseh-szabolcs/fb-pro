<?php

namespace App\Doctrine\Type;

use App\Attribute\Doctrine\JsonDocument;
use App\Component\Reader\AttributeReader;
use App\Services\ServiceTunnel;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use InvalidArgumentException;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonDocumentType extends JsonType
{
    public const NAME = 'json_document';

    private string $format = 'json';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        assert(is_object($value), 'JsonDocument must be an object.');
        $attribute = AttributeReader::fromClass($value, JsonDocument::class, true);
        if (empty($attribute)) {
            throw new InvalidArgumentException('Value-object is missing the JsonDocument attribute.');
        }

        $serializer = ServiceTunnel::get(SerializerInterface::class);

        return $serializer->serialize(
            [get_class($value) => $value],
            $this->format,
            ['groups' => [$attribute->group ?? 'default']],
        );
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (empty($value) || !is_string($value)) {
            return null;
        }

        $data = $this->dataDecode($value);
        $serializer = ServiceTunnel::get(SerializerInterface::class);


        return $serializer->deserialize($data['json'], $data['className'], $this->format, $this->context);
    }

    private function dataDecode(string $value): array
    {
        $typePattern = '/^\s*{\s*"([a-z0-9_\\\]+)"\s*:\s*{/i';
        $result = preg_match($typePattern, $value, $matches);
        assert($result && count($matches) > 1);
        $className = trim(str_replace('\\\\', '\\', $matches[1]));

        return [
            'className' => $className,
            'json' => sprintf('{%s', preg_replace($typePattern, '', preg_replace('/\s*}$/', '', $value))),
        ];
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
