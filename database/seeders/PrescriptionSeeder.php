<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = Appointment::all();
        foreach ($appointments as $appointment) {
            $drug_id = fake()->randomNumber(1, 39);
            Prescription::factory()->create([
                'drug_id' => $drug_id,
                'appointment_id' => $appointment->id,
            ]);
        }
    }
}
