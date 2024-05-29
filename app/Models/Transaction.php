<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_name',
        'patient_phone',
        'patient_age',
        'doctor_name',
        'doctor_phone',
        'appointment_date',
        'note',
        'amount_treatments',
        'amount_prescriptions',
        'amount_total',
        'payment_receipt',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
        'paid_at' => 'datetime',
        'appointment_date' => 'datetime'
    ];

    protected static function booted()
    {
        parent::booted();
        static::saving(function (Transaction $transaction) {
            // dd($transaction->payment_receipt);
            if (!empty($transaction->payment_receipt)) {
                $transaction->status = PaymentStatusEnum::PAID->value;
                $transaction->paid_at = now();
            }
        });
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class, 'transaction_id');
    }
}
