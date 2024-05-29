<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'gender',
        'fee',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => GenderEnum::class,
            'role' => RoleEnum::class,
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($user) {
        });
        static::updating(function ($user) {
            $role = $user->getRoleNames()->first() ?? RoleEnum::OPERATOR->value;
            $user->role = $role;
        });
    }

    public function hasPermission(String $permission): bool
    {
        return in_array($permission, $this->getPermissionsViaRoles()->pluck('name')->toArray());
    }

    public function clinics(): BelongsToMany
    {
        return
            $this->belongsToMany(Clinic::class)
            ->using(ClinicUser::class)
            ->withTimestamps();
    }

    public function clinic(): BelongsToMany
    {
        return $this->belongsToMany(Clinic::class)
            ->using(ClinicUser::class);
    }
}
