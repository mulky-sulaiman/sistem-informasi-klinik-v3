<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum ClinicTypeEnum: string
{

    case PRATAMA = 'pratama';
    case UTAMA = 'utama';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::PRATAMA => Str::ucfirst(self::PRATAMA->value),
            static::UTAMA => Str::ucfirst(self::UTAMA->value),
        };
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
