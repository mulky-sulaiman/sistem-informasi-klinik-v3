<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Appointment;
use App\Models\ClinicUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinic_users = ClinicUser::all();
        $i = 1;
        foreach ($clinic_users as $clinic_user) {
            $user = User::find($clinic_user->user_id);
            if ($user->hasRole(RoleEnum::DOCTOR->value)) {
                Appointment::factory()->create([
                    'clinic_user_id' => $clinic_user->id,
                    'patient_id' => $i,
                ]);
                $i++;
            }
        }
    }
}
