<?php

namespace App\Attribute\Security;

use App\Constants\Role;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final readonly class Grant
{
    const ROUTE_HOME = 'app_home';
    const ROUTE_GUEST = 'app_intro';

    public function __construct(
        public Role $role = Role::USER,
        public string $redirect = 'app_intro',
        public array $params = [],
        public bool $strict = false,
        public bool $throw = false,
    ) {}
}
