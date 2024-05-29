<?php

namespace App\Models;

use App\Enums\BloodTypeEnum;
use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'phone',
        'gender',
        'marital_status',
        'blood_type',
        'bio',
        'address',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
    ];

    protected $casts = [
        'birth_date' => 'datetime',
        'gender' => GenderEnum::class,
        'marital_status' => MaritalStatusEnum::class,
        'blood_type' => BloodTypeEnum::class,
        'province_id' => 'string',
        'regency_id' => 'string',
        'district_id' => 'string',
        'village_id' => 'string',
    ];

    protected static function booted()
    {
        parent::booted();
        static::saving(function ($patient) {
            $patient->age = Carbon::parse($patient->birth_date)->age;
        });
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}
