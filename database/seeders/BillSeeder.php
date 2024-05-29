<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatusEnum;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = Transaction::all();
        foreach ($transactions as $transaction) {
            $treatments = $transaction->appointment()->first()->treatments()->get();
            $prescriptions = $transaction->appointment()->first()->prescriptions()->get();
            // Bill Insertion
            foreach ($treatments as $treatment) {
                $bill = Bill::factory()->create([
                    'transaction_id' => $transaction->id,
                    'item_name' => $treatment->name,
                    'item_description' => $treatment->description,
                    'quantity' => $treatment->quantity,
                    'price' => $treatment->price,
                    'discount' => $treatment->discount,
                    'amount' => $treatment->amount,
                ]);
            }
            foreach ($prescriptions as $prescription) {
                $bill = Bill::factory()->create([
                    'transaction_id' => $transaction->id,
                    'item_name' => $prescription->drug()->first()->name,
                    'item_description' => $prescription->description,
                    'quantity' => $prescription->quantity,
                    'price' => $prescription->price,
                    'discount' => $prescription->discount,
                    'amount' => $prescription->amount,
                ]);
            }
        }
    }
}
