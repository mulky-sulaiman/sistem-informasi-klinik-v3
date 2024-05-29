<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum BloodTypeEnum: string
{

    case UNKNOWN = '';
    case APLUS = 'A+';
    case AMIN = 'A-';
    case BPLUS = 'B+';
    case BMIN = 'B-';
    case ABPLUS = 'AB+';
    case ABMIN = 'AB-';
    case OPLUS = 'O+';
    case OMIN = 'O-';


    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::UNKNOWN => 'Undefined',
            static::APLUS => Str::upper(self::APLUS->value),
            static::AMIN => Str::upper(self::AMIN->value),
            static::BPLUS => Str::upper(self::BPLUS->value),
            static::BMIN => Str::upper(self::BMIN->value),
            static::ABPLUS => Str::upper(self::ABPLUS->value),
            static::ABMIN => Str::upper(self::ABMIN->value),
            static::OPLUS => Str::upper(self::OPLUS->value),
            static::OMIN => Str::upper(self::OMIN->value),
        };
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
