<?php

namespace App\Security\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class GuestGranted
{
    public function __construct(
        public ?string $redirectRoute = 'app_home',
        public array $redirectRouteParams = [],
    ) {}
}
