<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PolyclinicSeeder::class,
            DoctorSeeder::class,
            AdminSeeder::class,
            ScheduleSeeder::class,
            PatientSeeder::class,
            MedicineSeeder::class,
        ]);
    }
}
