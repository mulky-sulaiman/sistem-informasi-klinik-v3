<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum AppointmentStatusEnum: string
{

    case SCHEDULED = 'scheduled';
    case DIAGNOSED = 'diagnosed';
    case PREPARED = 'prepared';
    case CONFIRMED = 'confirmed';
    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::SCHEDULED => ucwords(Str::replace('_', ' ', self::SCHEDULED->value)),
            static::DIAGNOSED => ucwords(Str::replace('_', ' ', self::DIAGNOSED->value)),
            static::PREPARED => ucwords(Str::replace('_', ' ', self::PREPARED->value)),
            static::CONFIRMED => ucwords(Str::replace('_', ' ', self::CONFIRMED->value)),
        };
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    public function color()
    {
        return match ($this) {
            static::SCHEDULED => 'primary',
            static::DIAGNOSED => 'warning',
            static::PREPARED => 'info',
            static::CONFIRMED => 'success',
        };
    }
}
