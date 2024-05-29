<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = Appointment::where('status', AppointmentStatusEnum::CONFIRMED->value)->get();
        foreach ($appointments as $appointment) {
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
            // Patient & Doctor Info
            $patient = $appointment->patient()->first();
            $doctor = $appointment->doctor()->first();
            Transaction::factory()->create([
                'appointment_id' => $appointment->id,
                'patient_name' => $patient->name,
                'patient_phone' => $patient->phone,
                'patient_age' => $patient->age,
                'doctor_name' => $doctor->name,
                'doctor_phone' => $doctor->phone,
                'appointment_date' => $appointment->schedule_date,
                'note' => $appointment->symptoms . '\n' . $appointment->diagnostic,
                'amount_treatments' => $total_treatments,
                'amount_prescriptions' => $total_prescriptions,
                'amount_total' => $total_treatments + $total_prescriptions,
                'payment_receipt' => null,
                'status' => PaymentStatusEnum::UNPAID->value,
                'paid_at' => null,
            ]);
        }
    }
}
