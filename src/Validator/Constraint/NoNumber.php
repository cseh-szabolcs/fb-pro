<?php

namespace App\Validator\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

#[Attribute(
    Attribute::TARGET_PROPERTY
    | Attribute::TARGET_METHOD
    | Attribute::IS_REPEATABLE
)]
final class NoNumber extends Regex
{
    public function __construct(
        ?string $message = 'Numbers are not allowed.',
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct(
            pattern: '/\d/',
            message: $message,
            match: false,
            groups: $groups,
            payload: $payload,
        );
    }

    public function validatedBy(): string
    {
        return RegexValidator::class;
    }
}
