<?php

namespace App\Enums;

/**
 * @method static self child()
 * @method static self adult()
 */
enum GuestAgeGroup
{
    protected static function values(): array
    {
        return [
            'child' => 'child',
            'adult' => 'adult',
        ];
    }

    protected static function labels(): array
    {
        return [
            'child' => 'Niño',
            'adult' => 'Adulto',
        ];
    }
}
