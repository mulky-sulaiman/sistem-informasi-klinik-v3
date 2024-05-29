<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum BillTypeEnum: string
{

    case TREATMENT = 'treatment';
    case PRESCRIPTION = 'prescription';
    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::TREATMENT => ucwords(Str::replace('_', ' ', self::TREATMENT->value)),
            static::PRESCRIPTION => ucwords(Str::replace('_', ' ', self::PRESCRIPTION->value)),
        };
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
