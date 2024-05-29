<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ModelHasRole extends Pivot
{
    use HasFactory;

    protected $table = 'model_has_roles';

    protected static function booted()
    {
        static::creating(function ($pivot_model) {
            dd('gablag');
        });
    }
}
