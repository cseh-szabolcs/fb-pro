<?php

declare(strict_types=1);

namespace App\Contracts\Entity;

use Symfony\Component\Uid\Uuid;

interface UuidAwareInterface
{
    public function getUuid(): Uuid;
}
