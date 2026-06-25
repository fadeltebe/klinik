<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PatientProfile;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Ibu Ratna',
            'email' => 'ratna@email.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        PatientProfile::create([
            'user_id' => $user->id,
            'full_name' => 'Ratna',
            'nik' => '3201234567890001',
            'date_of_birth' => Carbon::now()->subYears(35)->format('Y-m-d'),
            'gender' => 'female',
        ]);

        PatientProfile::create([
            'user_id' => $user->id,
            'full_name' => 'Dika',
            'nik' => '3201234567890002',
            'date_of_birth' => Carbon::now()->subYears(5)->format('Y-m-d'),
            'gender' => 'male',
        ]);

        PatientProfile::create([
            'user_id' => $user->id,
            'full_name' => 'Nenek Siti',
            'nik' => '3201234567890003',
            'date_of_birth' => Carbon::now()->subYears(70)->format('Y-m-d'),
            'gender' => 'female',
        ]);
    }
}
