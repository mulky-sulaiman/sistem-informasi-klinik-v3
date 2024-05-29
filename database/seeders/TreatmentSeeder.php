<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Treatment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = Appointment::all();
        foreach ($appointments as $appointment) {
            Treatment::factory()->count(2)->create([
                'treatment_category_id' => fake()->randomElement([2, 3, 4]),
                'appointment_id' => $appointment->id,
            ]);
        }
    }
}
