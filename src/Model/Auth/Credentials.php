<?php

declare(strict_types=1);

namespace App\Model\Auth;

final readonly class Credentials
{
    public function __construct(
        public string $identifier,
        public string $password,
    ) {}
}
