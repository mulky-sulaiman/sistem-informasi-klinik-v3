<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum PaymentStatusEnum: string
{

    case PAID = 'paid';
    case UNPAID = 'unpaid';
    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::PAID => ucwords(Str::replace('_', ' ', self::PAID->value)),
            static::UNPAID => ucwords(Str::replace('_', ' ', self::UNPAID->value)),
        };
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    public function color()
    {
        return match ($this) {
            static::PAID => 'success',
            static::UNPAID => 'danger',
        };
    }
}
