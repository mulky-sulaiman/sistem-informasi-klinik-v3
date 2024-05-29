<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\TreatmentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Treatment>
 */
class TreatmentFactory extends Factory
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
            'treatment_category_id' => TreatmentCategory::factory(),
            'appointment_id' => Appointment::factory(),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'quantity' => $qty,
            'price' => $price,
            'discount' => $discount,
            'amount' => $amount,
        ];
    }
}
