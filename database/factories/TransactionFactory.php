<?php

namespace Database\Factories;

use App\Enums\PaymentStatusEnum;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty1 = fake()->numberBetween(1, 10);
        $price1 = fake()->numberBetween(100000, 300000);
        $discount1 = fake()->randomElement([0, 25, 50, 75, 100]);
        $amount1 = $price1 - ($price1 * ($discount1 / 100));

        $qty2 = fake()->numberBetween(1, 10);
        $price2 = fake()->numberBetween(100000, 300000);
        $discount2 = fake()->randomElement([0, 25, 50, 75, 100]);
        $amount2 = $price2 - ($price2 * ($discount2 / 100));

        return [
            'appointment_id' => Appointment::factory(),
            'patient_name' => fake()->name(),
            'patient_phone' => fake()->phoneNumber(),
            'patient_age' => fake()->numberBetween(1, 100),
            'doctor_name' => fake()->name(),
            'doctor_phone' => fake()->phoneNumber(),
            'appointment_date' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'note' => fake()->paragraphs(2, true),
            'amount_treatments' => $amount1,
            'amount_prescriptions' => $amount2,
            'amount_total' => $amount1 + $amount2,
            'payment_receipt' => null,
            'status' => fake()->randomElement(PaymentStatusEnum::values()),
            'paid_at' => fake()->randomElement([now(), null]),
        ];
    }
}
