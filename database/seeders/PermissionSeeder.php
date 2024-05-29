<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Roles
            'create_role',
            'view_any_role',
            'view_role',
            'update_role',
            'delete_any_role',
            'delete_role',
            // Users
            'create_user',
            'view_any_user',
            'view_user',
            'update_user',
            'delete_any_user',
            'delete_user',
            // Patient
            'create_patient',
            'view_any_patient',
            'view_patient',
            'update_patient',
            'delete_any_patient',
            'delete_patient',
            // Clinic
            'create_clinic',
            'view_any_clinic',
            'view_clinic',
            'update_clinic',
            'delete_any_clinic',
            'delete_clinic',
            // Appointment
            'create_appointment',
            'view_any_appointment',
            'view_appointment',
            'update_appointment',
            'delete_any_appointment',
            'delete_appointment',
            // Drug
            'create_drug',
            'view_any_drug',
            'view_drug',
            'update_drug',
            'delete_any_drug',
            'delete_drug',
            // Drug Category
            'create_drug_category',
            'view_any_drug_category',
            'view_drug_category',
            'update_drug_category',
            'delete_any_drug_category',
            'delete_drug_category',
            // Treatment Category
            'create_treatment_category',
            'view_any_treatment_category',
            'view_treatment_category',
            'update_treatment_category',
            'delete_any_treatment_category',
            'delete_treatment_category',
            // Treatment
            'create_treatment',
            'view_any_treatment',
            'view_treatment',
            'update_treatment',
            'delete_any_treatment',
            'delete_treatment',
            // Prescription
            'create_prescription',
            'view_any_prescription',
            'view_prescription',
            'update_prescription',
            'delete_any_prescription',
            'delete_prescription',
            // Transaction
            'create_transaction',
            'view_any_transaction',
            'view_transaction',
            'update_transaction',
            'delete_any_transaction',
            'delete_transaction',
            // Bill
            'create_bill',
            'view_any_bill',
            'view_bill',
            'update_bill',
            'delete_any_bill',
            'delete_bill',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superadmin = Role::create(['name' => RoleEnum::SUPER_ADMIN->value]);

        $superadmin->syncPermissions($permissions);

        $admin = Role::create(['name' => RoleEnum::ADMIN->value]);

        $admin->syncPermissions([
            // Users
            'create_user',
            'view_any_user',
            'view_user',
            'update_user',
            'delete_any_user',
            'delete_user',
            // Patient
            'create_patient',
            'view_any_patient',
            'view_patient',
            'update_patient',
            'delete_any_patient',
            'delete_patient',
            // Clinic
            'create_clinic',
            'view_any_clinic',
            'view_clinic',
            'update_clinic',
            'delete_any_clinic',
            'delete_clinic',
            // Drug
            'create_drug',
            'view_any_drug',
            'view_drug',
            'update_drug',
            'delete_any_drug',
            'delete_drug',
            // Drug Category
            'create_drug_category',
            'view_any_drug_category',
            'view_drug_category',
            'update_drug_category',
            'delete_any_drug_category',
            'delete_drug_category',
            // Appointment
            'create_appointment',
            'view_any_appointment',
            'view_appointment',
            'update_appointment',
            'delete_any_appointment',
            'delete_appointment',
            // Treatment Category
            'create_treatment_category',
            'view_any_treatment_category',
            'view_treatment_category',
            'update_treatment_category',
            'delete_any_treatment_category',
            'delete_treatment_category',
            // Treatment
            'create_treatment',
            'view_any_treatment',
            'view_treatment',
            'update_treatment',
            'delete_any_treatment',
            'delete_treatment',
            // Prescription
            'create_prescription',
            'view_any_prescription',
            'view_prescription',
            'update_prescription',
            'delete_any_prescription',
            'delete_prescription',
            // Transaction
            'create_transaction',
            'view_any_transaction',
            'view_transaction',
            'update_transaction',
            'delete_any_transaction',
            'delete_transaction',
            // Bill
            'create_bill',
            'view_any_bill',
            'view_bill',
            'update_bill',
            'delete_any_bill',
            'delete_bill',
        ]);

        $operator = Role::create(['name' => RoleEnum::OPERATOR->value]);

        $operator->syncPermissions([
            // Users
            'view_any_user',
            'view_user',
            'update_user',
            // Patient
            'create_patient',
            'view_any_patient',
            'view_patient',
            'update_patient',
            'delete_any_patient',
            'delete_patient',
            // Clinic
            // 'create_clinic',
            'view_any_clinic',
            'view_clinic',
            'update_clinic',
            // Appointment
            'create_appointment',
            'view_any_appointment',
            'view_appointment',
            'update_appointment',
            // 'delete_any_appointment',
            // 'delete_appointment',
            // Drug
            'view_any_drug',
            'view_drug',
            // Drug Category
            'view_any_drug_category',
            'view_drug_category',
            // Treatment Category
            'view_any_treatment_category',
            'view_treatment_category',
            // Treatment
            'view_any_treatment',
            'view_treatment',
            // Prescription
            'view_any_prescription',
            'view_prescription',
            // Transaction
            // 'create_transaction',
            'view_any_transaction',
            'view_transaction',
            'update_transaction',
            // 'delete_any_transaction',
            // 'delete_transaction',
            // Bill
            // 'create_bill',
            'view_any_bill',
            'view_bill',
            'update_bill',
            // 'delete_any_bill',
            // 'delete_bill',
        ]);

        $operator = Role::create(['name' => RoleEnum::PHARMACIST->value]);

        $operator->syncPermissions([
            // Users
            'view_any_user',
            'view_user',
            'update_user',
            // Patient
            'view_any_patient',
            'view_patient',
            // Clinic
            'view_any_clinic',
            'view_clinic',
            // Appointment
            // 'create_appointment',
            'view_any_appointment',
            'view_appointment',
            // 'update_appointment',
            // 'delete_any_appointment',
            // 'delete_appointment',
            // Drug
            'create_drug',
            'view_any_drug',
            'view_drug',
            'update_drug',
            'delete_any_drug',
            'delete_drug',
            // Drug Category
            'create_drug_category',
            'view_any_drug_category',
            'view_drug_category',
            'update_drug_category',
            'delete_any_drug_category',
            'delete_drug_category',
            // Treatment Category
            'create_treatment_category',
            'view_any_treatment_category',
            'view_treatment_category',
            'update_treatment_category',
            'delete_any_treatment_category',
            'delete_treatment_category',
            // Treatment
            'view_any_treatment',
            'view_treatment',
            // Prescription
            'create_prescription',
            'view_any_prescription',
            'view_prescription',
            'update_prescription',
            'delete_any_prescription',
            'delete_prescription',
            // Transaction
            // 'create_transaction',
            'view_any_transaction',
            'view_transaction',
            //'update_transaction',
            // 'delete_any_transaction',
            // 'delete_transaction',
            // Bill
            // 'create_bill',
            'view_any_bill',
            'view_bill',
            //'update_bill',
            // 'delete_any_bill',
            // 'delete_bill',
        ]);

        $operator = Role::create(['name' => RoleEnum::DOCTOR->value]);

        $operator->syncPermissions([
            // Users
            'view_any_user',
            'view_user',
            'update_user',
            // Patient
            'view_any_patient',
            'view_patient',
            // Clinic
            'view_any_clinic',
            'view_clinic',
            // Appointment
            // 'create_appointment',
            'view_any_appointment',
            'view_appointment',
            'update_appointment',
            // 'delete_any_appointment',
            // 'delete_appointment',
            // Drug
            'view_any_drug',
            'view_drug',
            // Drug Category
            'view_any_drug_category',
            'view_drug_category',
            // Treatment Category
            'create_treatment_category',
            'view_any_treatment_category',
            'view_treatment_category',
            'update_treatment_category',
            'delete_any_treatment_category',
            'delete_treatment_category',
            // Treatment
            'create_treatment',
            'view_any_treatment',
            'view_treatment',
            'update_treatment',
            'delete_any_treatment',
            'delete_treatment',
            // Prescription
            'create_prescription',
            'view_any_prescription',
            'view_prescription',
            'update_prescription',
            'delete_any_prescription',
            'delete_prescription',
            // Transaction
            // 'create_transaction',
            'view_any_transaction',
            'view_transaction',
            //'update_transaction',
            // 'delete_any_transaction',
            // 'delete_transaction',
            // Bill
            // 'create_bill',
            'view_any_bill',
            'view_bill',
            //'update_bill',
            // 'delete_any_bill',
            // 'delete_bill',
        ]);
    }
}
