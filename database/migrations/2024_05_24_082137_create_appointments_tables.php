<?php

use App\Enums\AppointmentStatusEnum;
use App\Enums\RoleEnum;
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
        // Appointment
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->unsignedBigInteger('clinic_user_id');
            $table->foreign('clinic_user_id')->references('id')->on('clinic_user')->whereHas('user', function ($query) {
                $query->where('role', RoleEnum::DOCTOR->value);
            });
            $table->date('schedule_date');
            $table->integer('height');
            $table->integer('weight');
            $table->string('blood_pressure');
            $table->text('symptoms');
            $table->text('diagnostic')->nullable();
            $table->enum('status', AppointmentStatusEnum::values())->default(AppointmentStatusEnum::SCHEDULED->value);
            $table->timestamps();
        });
        // Treatment Category
        Schema::create('treatment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });
        // Treatment
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_category_id')->constrained();
            $table->foreignId('appointment_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('amount')->default(0);
            $table->timestamps();
        });
        // Prescription
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drug_id')->constrained();
            $table->foreignId('appointment_id')->constrained();
            $table->text('description');
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('amount')->default(0);
            $table->boolean('is_prepared')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('treatment_categories');
        Schema::dropIfExists('treatments');
        Schema::dropIfExists('prescriptions');
    }
};
