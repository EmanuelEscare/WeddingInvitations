<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * @method static self child()
 * @method static self adult()
 */
enum GuestAgeGroup: string implements HasLabel
{
    case child = 'child';
    case adult = 'adult';

    public function getLabel(): string
    {
        return match ($this) {
            self::child => __('Child'),
            self::adult => __('Adult'),
        };
    }
}
