<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\DrugCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drug>
 */
class DrugFactory extends Factory
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
            'drug_category_id' => DrugCategory::factory(),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'stock' => fake()->randomNumber(3, false),
            'price' => fake()->randomNumber(6, true),
            'in_stock' => fake()->randomElement([0, 1]),
        ];
    }
}
