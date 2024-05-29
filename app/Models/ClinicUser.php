<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClinicUser extends Pivot
{
    use HasFactory;
    // protected $table = "clinic_users";
    // public $timestamps = false;

    protected $fillable = [
        'clinic_id',
        'user_id',
        //'role',
    ];
    protected $casts = [
        //'role' => RoleEnum::class,
        //'label' => 'string'
    ];

    protected static function booted()
    {
        static::creating(function ($pivot_model) {
            // $u = User::find($pivot_model->user_id);
            // $pivot_model->role = $u->getRoleNames()->first();
        });
    }

    // public function clinics(): HasMany
    // {
    //     return $this->hasMany(Appointment::class, 'clinic_id');
    // }

    // public function users(): HasMany
    // {
    //     return $this->hasMany(Appointment::class, 'user_id');
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}
