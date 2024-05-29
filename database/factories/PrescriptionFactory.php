<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Drug;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prescription>
 */
class PrescriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = fake()->numberBetween(1, 10);
        $price = fake()->numberBetween(100000, 300000);
        $discount = fake()->randomElement([0, 25, 50, 75, 100]);
        $amount = $price - ($price * ($discount / 100));
        return [
            'drug_id' => Drug::factory(),
            'appointment_id' => Appointment::factory(),
            'description' => fake()->sentence(),
            'quantity' => $qty,
            'price' => $price,
            'discount' => $discount,
            'amount' => $amount,
            'is_prepared' => fake()->randomElement([true, false]),
        ];
    }
}
