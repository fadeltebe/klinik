<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DoctorAdmin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin1 = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        DoctorAdmin::create([
            'user_id' => $admin1->id,
            'doctor_id' => null,
        ]);

        $admin2 = User::create([
            'name' => 'Admin Anak',
            'email' => 'admin.anak@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        DoctorAdmin::create([
            'user_id' => $admin2->id,
            'doctor_id' => 1,
        ]);
    }
}
