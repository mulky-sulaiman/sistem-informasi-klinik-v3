<?php

use App\Enums\ClinicTypeEnum;
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
        // Clinics Table
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ClinicTypeEnum::values())->default(ClinicTypeEnum::PRATAMA->value);
            $table->tinyText('description')->nullable();
            // Region
            $table->text('address')->nullable();
            $table->char('province_id', 2)->index()->nullable();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->char('regency_id', 4)->index()->nullable();
            $table->foreign('regency_id')->references('id')->on('regencies');
            $table->char('district_id', 7)->index()->nullable();
            $table->foreign('district_id')->references('id')->on('districts');
            $table->char('village_id', 10)->index()->nullable();
            $table->foreign('village_id')->references('id')->on('villages');
            // --
            $table->timestamps();
        });

        // Pivot table for Clinics and Users
        Schema::create('clinic_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained();
            $table->foreignId('user_id')->constrained();
            // $table->enum('role', [RoleEnum::OPERATOR->value, RoleEnum::PHARMACIST->value, RoleEnum::DOCTOR->value])->default(RoleEnum::OPERATOR->value);
            // $table->primary(['clinic_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
        Schema::dropIfExists('clinic_user');
    }
};
