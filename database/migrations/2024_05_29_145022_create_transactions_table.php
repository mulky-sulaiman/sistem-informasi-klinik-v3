<?php

use App\Enums\BillTypeEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->nullable()->constrained();
            $table->string('patient_name');
            $table->string('patient_phone')->nullable();
            $table->tinyInteger('patient_age')->default(0);
            $table->string('doctor_name');
            $table->string('doctor_phone')->nullable();
            $table->date('appointment_date');
            $table->text('note')->nullable();
            $table->integer('amount_treatments')->default(0);
            $table->integer('amount_prescriptions')->default(0);
            $table->integer('amount_total')->default(0);
            $table->string('payment_receipt', 2048)->nullable();
            $table->enum('status', PaymentStatusEnum::values())->default(PaymentStatusEnum::UNPAID->value);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
        // Bills
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->nullable()->constrained();
            $table->enum('type', BillTypeEnum::values())->default(BillTypeEnum::TREATMENT->value);
            $table->string('item_name');
            $table->text('item_description');
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('bills');
    }
};
