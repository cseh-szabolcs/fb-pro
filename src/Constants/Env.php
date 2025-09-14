<?php

declare(strict_types=1);

namespace App\Constants;

enum Env: string
{
    case Dev = 'dev';
    case Prod = 'prod';
    case Test = 'test';
}
