<?php

namespace App\Constants;

enum Lang: string
{
    case EN = 'en';
    case DE = 'de';

    public static function getDefault(): string
    {
        return self::EN->value;
    }

    public static function getSupported(): array
    {
        return [
            self::EN->value,
            self::DE->value,
        ];
    }

    public function isSupported(): bool
    {
        return in_array($this->value, self::getSupported());
    }
}
