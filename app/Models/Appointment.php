<?php

namespace App\Models;

use App\Enums\AppointmentStatusEnum;
use App\Enums\BillTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'clinic_user_id',
        'schedule_date',
        'height',
        'weight',
        'blood_pressure',
        'symptoms',
        'diagnostic',
        'status',
    ];

    protected $casts = [
        'schedule_date' => 'datetime',
        'height' => 'integer',
        'weight' => 'integer',
        'status' => AppointmentStatusEnum::class,
    ];

    protected static function booted()
    {
        parent::booted();
        static::creating(function ($appointment) {
            $appointment->status = AppointmentStatusEnum::SCHEDULED;
        });
        static::created(function ($appointment) {
            $appointment_id = $appointment->id;
            $u = User::find($appointment->clinic_doctor()->first()->user_id);
            $fee = $u->fee;
            $treatment = Treatment::create([
                'treatment_category_id' => 1,
                'appointment_id' => $appointment_id,
                'name' => 'Doctor\'s Fee',
                'description' => '',
                'quantity' => 1,
                'price' => $fee,
                'discount' => 0,
                'amount' => $fee,
            ]);
        });
        static::saving(function ($appointment) {
            $status = $appointment->status;
            if ($status == AppointmentStatusEnum::CONFIRMED) {
                // Treatments
                $treatments = $appointment->treatments()->get();
                $total_treatments = 0;
                foreach ($treatments as $treatment) {
                    $total_treatments = $total_treatments + $treatment->amount;
                }
                // Prescriptions
                // $prescriptions = Prescription::where('application_id', $appointment->id)->where('is_prepared', true)->get();
                $prescriptions = $appointment->prescriptions()->get();
                $total_prescriptions = 0;
                foreach ($prescriptions as $prescription) {
                    $total_prescriptions = $total_prescriptions + $prescription->amount;
                }
                // Transaction Insertion
                $transaction = Transaction::create([
                    'appointment_id' => $appointment->id,
                    'patient_name' => $appointment->patient()->first()->name,
                    'patient_phone' => $appointment->patient()->first()->phone,
                    'patient_age' => $appointment->patient()->first()->age,
                    'doctor_name' => $appointment->clinic_doctor()->first()->user()->first()->name,
                    'doctor_phone' => $appointment->clinic_doctor()->first()->user()->first()->phone,
                    'appointment_date' => $appointment->schedule_date,
                    'note' => $appointment->symptoms . '\n' . $appointment->diagnostic,
                    'amount_treatments' => $total_treatments,
                    'amount_prescriptions' => $total_prescriptions,
                    'amount_total' => $total_treatments + $total_prescriptions,
                    'payment_receipt' => null,
                    'status' => PaymentStatusEnum::UNPAID->value,
                    'paid_at' => null,
                ]);
                // Bill Insertion
                foreach ($treatments as $treatment) {
                    $bill = Bill::create([
                        'transaction_id' => $transaction->id,
                        'type' => BillTypeEnum::TREATMENT->value,
                        'item_name' => $treatment->name,
                        'item_description' => $treatment->description,
                        'quantity' => $treatment->quantity,
                        'price' => $treatment->price,
                        'discount' => $treatment->discount,
                        'amount' => $treatment->amount,
                    ]);
                }
                foreach ($prescriptions as $prescription) {
                    $bill = Bill::create([
                        'transaction_id' => $transaction->id,
                        'type' => BillTypeEnum::PRESCRIPTION->value,
                        'item_name' => $prescription->drug()->first()->name,
                        'item_description' => $prescription->description,
                        'quantity' => $prescription->quantity,
                        'price' => $prescription->price,
                        'discount' => $prescription->discount,
                        'amount' => $prescription->amount,
                    ]);
                }
            }
        });
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function clinic_doctor(): BelongsTo
    {
        return $this->belongsTo(ClinicUser::class, 'clinic_user_id')->whereHas('user', function ($query) {
            $query->where('role', RoleEnum::DOCTOR->value);
        });
    }

    public function clinic_user(): BelongsTo
    {
        return $this->belongsTo(ClinicUser::class, 'clinic_user_id');
    }


    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class, 'appointment_id');
    }
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class, 'appointment_id');
    }
}
