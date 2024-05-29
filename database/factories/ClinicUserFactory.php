<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClinicUser>
 */
class ClinicUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clinic_id' => Clinic::factory(),
            'user_id' => User::factory(),
            // 'role' => fake()->randomElement([RoleEnum::OPERATOR->value, RoleEnum::PHARMACIST->value, RoleEnum::DOCTOR->value,])
        ];
    }
}
