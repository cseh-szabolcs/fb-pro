<?php

namespace App\Doctrine\Type;

use App\Attribute\Doctrine\JsonDocument;
use App\Component\Reader\AttributeReader;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use InvalidArgumentException;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonDocumentType extends JsonType
{
    public const NAME = 'json_document';

    private string $format = 'json';

    private SerializerInterface $serializer;

    private array $context = [
        'groups' => ['orm'],
    ];

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (!is_object($value)) {
            throw new InvalidArgumentException('JsonDocumentType supports only objects.');
        }

        $attribute = AttributeReader::fromClass($value, JsonDocument::class);
        if (empty($attribute)) {
            throw new InvalidArgumentException('Value-object is missing the JsonDocument attribute.');
        }

        return $this->serializer->serialize(
            [get_class($value) => $value,],
            $this->format,
            $this->context,
        );
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (empty($value) || !is_string($value)) {
            return null;
        }

        $typePattern = '/^\s*{\s*"([a-z0-9_\\\]+)"\s*:\s*{/i';
        $result = preg_match($typePattern, $value, $matches);
        assert($result && count($matches) > 1);
        $className = trim(str_replace('\\\\', '\\', $matches[1]));
        $json = sprintf('{%s', preg_replace($typePattern, '', preg_replace('/\s*}$/', '', $value)));

        return $this->serializer->deserialize($json, $className, $this->format, $this->context);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Called by the Dependency Injection component.
     */
    public function injectSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }
}
