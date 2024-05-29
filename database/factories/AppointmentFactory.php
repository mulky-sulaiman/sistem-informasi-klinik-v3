<?php

namespace Database\Factories;

use App\Enums\AppointmentStatusEnum;
use App\Models\ClinicUser;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'clinic_user_id' => ClinicUser::factory(),
            'schedule_date' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'height' => fake()->numberBetween(140, 200),
            'weight' => fake()->numberBetween(40, 120),
            'blood_pressure' => fake()->numberBetween(50, 200) . '/' . fake()->numberBetween(50, 200),
            'symptoms' => fake()->paragraphs(2, true),
            'diagnostic' => fake()->paragraphs(2, true),
            'status' => fake()->randomElement(AppointmentStatusEnum::values())
        ];
    }
}
