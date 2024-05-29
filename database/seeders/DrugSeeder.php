<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Drug;
use App\Models\DrugCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = Clinic::all();
        $categories = DrugCategory::all();

        foreach ($clinics as $clinic) {
            foreach ($categories as $category) {
                Drug::factory()->create([
                    'clinic_id' => $clinic->id,
                    'drug_category_id' => $category->id,
                    'name' => fake()->word(),
                    'description' => fake()->sentence(),
                    'stock' => fake()->randomNumber(3, false),
                    'price' => fake()->randomNumber(6, true),
                    'in_stock' => fake()->randomElement([0, 1]),
                ]);
            }
        }
    }
}
