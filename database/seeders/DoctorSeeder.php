<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $docUser1 = User::create([
            'name' => 'dr. Andi Pratama, Sp.A',
            'email' => 'andi@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
        Doctor::create([
            'id' => 1,
            'user_id' => $docUser1->id,
            'polyclinic_id' => 1, // Anak
            'name' => 'dr. Andi Pratama, Sp.A',
            'specialization' => 'Pediatrics',
            'license_number' => 'STR-1234567890',
        ]);

        $docUser2 = User::create([
            'name' => 'dr. Sari Dewi, Sp.OG',
            'email' => 'sari@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
        Doctor::create([
            'id' => 2,
            'user_id' => $docUser2->id,
            'polyclinic_id' => 2, // Kandungan
            'name' => 'dr. Sari Dewi, Sp.OG',
            'specialization' => 'Obgyn',
            'license_number' => 'STR-2234567890',
        ]);

        $docUser3 = User::create([
            'name' => 'dr. Budi Santoso, Sp.THT',
            'email' => 'budi@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
        Doctor::create([
            'id' => 3,
            'user_id' => $docUser3->id,
            'polyclinic_id' => 3, // THT
            'name' => 'dr. Budi Santoso, Sp.THT',
            'specialization' => 'ENT',
            'license_number' => 'STR-3234567890',
        ]);
    }
}
