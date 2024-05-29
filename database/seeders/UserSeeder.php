<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Super Admin
        $u1 = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => RoleEnum::SUPER_ADMIN->value,
        ]);
        $u1->assignRole(RoleEnum::SUPER_ADMIN->value);

        // 2. Admin
        $u2 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => RoleEnum::ADMIN->value,
        ]);
        $u2->assignRole(RoleEnum::ADMIN->value);

        // 3. Operators
        $u3 = User::factory()->create([
            'name' => 'Operator Clinic 1',
            'email' => 'operator.1@example.com',
            'role' => RoleEnum::OPERATOR->value,
        ]);
        $u3->assignRole(RoleEnum::OPERATOR->value);

        $u4 = User::factory()->create([
            'name' => 'Operator Clinic 2',
            'email' => 'operator.2@example.com',
            'role' => RoleEnum::OPERATOR->value,
        ]);
        $u4->assignRole(RoleEnum::OPERATOR->value);

        $u5 = User::factory()->create([
            'name' => 'Operator Clinic 3',
            'email' => 'operator.3@example.com',
            'role' => RoleEnum::OPERATOR->value,
        ]);
        $u5->assignRole(RoleEnum::OPERATOR->value);

        $u6 = User::factory()->create([
            'name' => 'Operator Clinic 4',
            'email' => 'operator.4@example.com',
            'role' => RoleEnum::OPERATOR->value,
        ]);
        $u6->assignRole(RoleEnum::OPERATOR->value);

        $u7 = User::factory()->create([
            'name' => 'Operator Clinic 5',
            'email' => 'operator.5@example.com',
            'role' => RoleEnum::OPERATOR->value,
        ]);
        $u7->assignRole(RoleEnum::OPERATOR->value);

        // 4. Pharmacists
        $u8 = User::factory()->create([
            'name' => 'Pharmacist Clinic 1',
            'email' => 'pharmacist.1@example.com',
        ]);
        $u8->assignRole(RoleEnum::PHARMACIST->value);

        $u9 = User::factory()->create([
            'name' => 'Pharmacist Clinic 2',
            'email' => 'pharmacist.2@example.com',
            'role' => RoleEnum::PHARMACIST->value,
        ]);
        $u9->assignRole(RoleEnum::PHARMACIST->value);

        $u10 = User::factory()->create([
            'name' => 'Pharmacist Clinic 3',
            'email' => 'pharmacist.3@example.com',
            'role' => RoleEnum::PHARMACIST->value,
        ]);
        $u10->assignRole(RoleEnum::PHARMACIST->value);

        $u11 = User::factory()->create([
            'name' => 'Pharmacist Clinic 4',
            'email' => 'pharmacist.4@example.com',
            'role' => RoleEnum::PHARMACIST->value,
        ]);
        $u11->assignRole(RoleEnum::PHARMACIST->value);

        $u12 = User::factory()->create([
            'name' => 'Pharmacist Clinic 5',
            'email' => 'pharmacist.5@example.com',
            'role' => RoleEnum::PHARMACIST->value,
        ]);
        $u12->assignRole(RoleEnum::PHARMACIST->value);

        // 5. Doctors
        $u13 = User::factory()->create([
            'name' => 'Doctor Clinic 1',
            'email' => 'doctor.1@example.com',
            'role' => RoleEnum::DOCTOR->value,
            'fee' => 100000
        ]);
        $u13->assignRole(RoleEnum::DOCTOR->value);

        $u14 = User::factory()->create([
            'name' => 'Doctor Clinic 2',
            'email' => 'doctor.2@example.com',
            'role' => RoleEnum::DOCTOR->value,
            'fee' => 200000
        ]);
        $u14->assignRole(RoleEnum::DOCTOR->value);

        $u15 = User::factory()->create([
            'name' => 'Doctor Clinic 3',
            'email' => 'doctor.3@example.com',
            'role' => RoleEnum::DOCTOR->value,
            'fee' => 300000
        ]);
        $u15->assignRole(RoleEnum::DOCTOR->value);

        $u16 = User::factory()->create([
            'name' => 'Doctor Clinic 4',
            'email' => 'doctor.4@example.com',
            'role' => RoleEnum::DOCTOR->value,
            'fee' => 400000
        ]);
        $u16->assignRole(RoleEnum::DOCTOR->value);

        $u17 = User::factory()->create([
            'name' => 'Doctor Clinic 5',
            'email' => 'doctor.5@example.com',
            'role' => RoleEnum::DOCTOR->value,
            'fee' => 500000
        ]);
        $u17->assignRole(RoleEnum::DOCTOR->value);
    }
}
