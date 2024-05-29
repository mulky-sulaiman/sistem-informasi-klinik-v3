<?php

namespace Database\Seeders;

use App\Models\TreatmentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Category 0' => 'Docotor Fee',
            'Category A' => 'General Checkup',
            'Category B' => 'External Injuries',
            'Category C' => 'Internal Injuries'
        ];
        foreach ($categories as $key => $value) {
            TreatmentCategory::factory()->create([
                'name' => $key,
                'description' => $value,
            ]);
        };
    }
}
