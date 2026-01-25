<?php

namespace App\Contracts;

interface OutputExtensionInterface
{
    public static function supports(object $data, array $context = []): bool;
}
