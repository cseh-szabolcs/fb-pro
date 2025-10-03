<?php

namespace App\Validator\Constraint;

use App\Validator\EmailAvailableValidator;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(
    Attribute::TARGET_CLASS
    | Attribute::TARGET_PROPERTY
    | Attribute::TARGET_METHOD
    | Attribute::IS_REPEATABLE
)]
final class EmailAvailable extends Constraint
{
    public string $message = 'The email address "{{ value }}" already exists.';

    public function __construct(?array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
    }

    public function validatedBy(): string
    {
        return EmailAvailableValidator::class;
    }

    public function getTargets(): array
    {
        return [
            self::CLASS_CONSTRAINT,
            self::PROPERTY_CONSTRAINT,
        ];
    }
}
