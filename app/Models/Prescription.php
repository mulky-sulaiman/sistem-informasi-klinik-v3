<?php

namespace App\Models;

use App\Enums\AppointmentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'drug_id',
        'appointment_id',
        'description',
        'quantity',
        'price',
        'discount',
        'amount',
        'is_prepared',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer',
        'discount' => 'integer',
        'amount' => 'integer',
        'is_prepared' => 'boolean',
    ];

    protected static function booted()
    {
        parent::booted();
        static::saving(function ($prescription) {
            // Price
            $drug = $prescription->drug()->first();
            $prescription->price = $drug->price;
            // Amount
            $q = $prescription->quantity;
            $p = $prescription->price;
            $d = $prescription->discount;
            $a = $q * ($p - ($p * ($d / 100)));
            $prescription->amount = $a;
            // Quantity update
            $ds = $drug->stock;
            $stock_count = $ds - $q;
            $drug->stock = $stock_count;
            if ($stock_count <= 0) {
                $drug->in_stock = false;
            }
            $drug->save();
        });
        static::saved(function ($prescription) {
            // Is Prepared
            $appointment = $prescription->appointment()->first();
            $prescriptions = $appointment->prescriptions()->get();
            $total = count($prescriptions);
            $prepared = 0;
            foreach ($prescriptions as $p) {
                if ($p->is_prepared) {
                    $prepared++;
                }
            }
            if ($prepared == $total) {
                $appointment->status = AppointmentStatusEnum::PREPARED;
                $appointment->save();
            }
        });
        static::deleting(function ($prescription) {
            $drug = $prescription->drug()->first();
            $q = $prescription->quantity;
            // Quantity update
            $ds = $drug->stock;
            $stock_count = $ds + $q;
            $drug->stock = $stock_count;
            if ($stock_count > 0) {
                $drug->in_stock = true;
            }
            $drug->save();
        });
    }

    public function drug(): BelongsTo
    {
        return $this->belongsTo(Drug::class, 'drug_id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Drug::class, 'drug_id');
    }

    // public function clinic_drug(): BelongsTo
    // {
    //     return $this->belongsTo(ClinicUser::class, 'clinic_user_id')->whereHas('user', function ($query) {
    //         $query->where('role', RoleEnum::DOCTOR->value);
    //     });
    // }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function setPrepare()
    {
        $this->is_prepared = true;
        return $this->save();
    }
}
