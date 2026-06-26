<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polyclinics = [
            ['id' => 1, 'name' => 'Poli Anak', 'description' => 'Klinik spesialis anak', 'icon' => 'baby'],
            ['id' => 2, 'name' => 'Poli Kandungan', 'description' => 'Klinik kehamilan dan kandungan', 'icon' => 'activity'],
            ['id' => 3, 'name' => 'Poli THT', 'description' => 'Klinik telinga hidung tenggorokan', 'icon' => 'ear'],
            ['id' => 4, 'name' => 'Poli Umum', 'description' => 'Klinik umum', 'icon' => 'stethoscope'],
            ['id' => 5, 'name' => 'Poli Gigi', 'description' => 'Klinik kesehatan gigi', 'icon' => 'smile'],
        ];

        foreach ($polyclinics as $poly) {
            \App\Models\Polyclinic::create($poly);
        }
    }
}
