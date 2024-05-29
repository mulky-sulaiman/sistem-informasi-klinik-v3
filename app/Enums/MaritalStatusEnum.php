<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum MaritalStatusEnum: string
{

    case UNKNOWN = '';
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::UNKNOWN => 'Undefined',
            static::SINGLE => Str::ucfirst(self::SINGLE->value),
            static::MARRIED => Str::ucfirst(self::MARRIED->value),
            static::DIVORCED => Str::ucfirst(self::DIVORCED->value),
        };
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    public function icon()
    {
        return match ($this) {
            static::UNKNOWN => 'tabler-question-mark',
            static::SINGLE => 'tabler-user',
            static::MARRIED => 'tabler-users-plus',
            static::DIVORCED => 'tabler-users-minus',
        };
    }
}
