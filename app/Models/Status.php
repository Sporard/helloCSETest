<?php

namespace App\Models;

enum Status: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
