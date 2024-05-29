<?php

namespace Database\Factories;

use App\Enums\ClinicTypeEnum;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $village = Village::inRandomOrder()->limit(1)->get()->first();
        $district = $village->district;
        $regency = $district->regency;
        $province = $regency->province;
        return [
            'name' => 'Clinic ' . ucfirst(fake()->word()),
            'type' => fake()->randomElement(ClinicTypeEnum::values()),
            'description' => fake()->sentence(),
            'address' => fake()->address(),
            'province_id' => $province->id,
            'regency_id' => $regency->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
        ];
    }
}
