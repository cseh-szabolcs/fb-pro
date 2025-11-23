<?php

namespace App\Constants;

use App\Traits\Pattern\StaticTrait;

final class Http
{
    use StaticTrait;

    const HEADER_AUTH_TOKEN = 'X-Authorization-Token';
}
