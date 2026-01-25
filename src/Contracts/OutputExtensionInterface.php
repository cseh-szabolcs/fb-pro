<?php

namespace App\Contracts;

interface OutputExtensionInterface
{
    public static function supports(object $subject, array $context = []): bool;
}
