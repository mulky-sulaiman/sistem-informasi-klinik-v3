<?php

namespace Database\Factories;

use App\Enums\BloodTypeEnum;
use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
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
            // 'nik' => fake()->randomNumber(9, true) . fake()->randomNumber(6, true),
            'name' => fake()->name(),
            'phone' => fake()->numberBetween(1111111111, 9999999999999),
            'birth_date' => fake()->dateTimeBetween('-50 year', '-18 year'),
            'gender' => fake()->randomElement([GenderEnum::MALE->value, GenderEnum::FEMALE->value]),
            'marital_status' => fake()->randomElement([MaritalStatusEnum::SINGLE->value, MaritalStatusEnum::MARRIED->value, MaritalStatusEnum::DIVORCED->value]),
            'blood_type' => fake()->randomElement(BloodTypeEnum::values()),
            'bio' => fake()->paragraphs(2, true),
            'address' => fake()->address(),
            'province_id' => $province->id,
            'regency_id' => $regency->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
        ];
    }
}
