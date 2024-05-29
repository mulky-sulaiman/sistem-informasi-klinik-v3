<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum GenderEnum: string
{

    case UNKNOWN = '';
    case MALE = 'male';
    case FEMALE = 'female';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::UNKNOWN => 'Undefined',
            static::MALE => Str::ucfirst(self::MALE->value),
            static::FEMALE => Str::ucfirst(self::FEMALE->value),
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
            static::MALE => 'tabler-gender-male',
            static::FEMALE => 'tabler-gender-female',
        };
    }
    public function avatar()
    {
        return match ($this) {
            static::UNKNOWN => '/static/avatars/avatar_unknown_2.png',
            static::MALE => '/static/avatars/avatar_male.png',
            static::FEMALE => '/static/avatars/avatar_female.png',
        };
    }
}
