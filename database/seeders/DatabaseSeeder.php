<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IndoRegionSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            PatientSeeder::class,
            ClinicSeeder::class,
            ClinicUserSeeder::class,
            DrugCategorySeeder::class,
            DrugSeeder::class,
            TreatmentCategorySeeder::class,
            AppointmentSeeder::class,
            PrescriptionSeeder::class,
            // TransactionSeeder::class,
            // BillSeeder::class,
        ]);
    }
}
