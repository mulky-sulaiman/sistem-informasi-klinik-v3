<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Clinic;
use App\Models\ClinicUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = Clinic::all();
        $roles = [
            RoleEnum::OPERATOR->value,
            RoleEnum::PHARMACIST->value,
            RoleEnum::DOCTOR->value,
        ];
        $i = 1;
        foreach ($clinics as $clinic) {
            foreach ($roles as $role) {
                $u = User::query()->where('email', 'LIKE', $role . '.' . $i . '%')->first();
                $clinicuser = ClinicUser::factory()->create([
                    'clinic_id' => $clinic->id,
                    'user_id' => $u->id,
                    // 'role' => $role,
                ]);
            }
            $i++;
        }
    }
}
