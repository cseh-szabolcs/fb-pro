<?php

namespace App\Attribute\Request;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final readonly class XhrRequest
{
    public function __construct() {}
}
