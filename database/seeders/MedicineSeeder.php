<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            ['name' => 'Paracetamol 500mg', 'code' => 'MED-001', 'type' => 'Tablet', 'stock' => 100, 'price' => 5000, 'description' => 'Obat penurun panas dan pereda nyeri'],
            ['name' => 'Amoxicillin 500mg', 'code' => 'MED-002', 'type' => 'Kapsul', 'stock' => 50, 'price' => 15000, 'description' => 'Antibiotik'],
            ['name' => 'Ibuprofen 400mg', 'code' => 'MED-003', 'type' => 'Tablet', 'stock' => 75, 'price' => 8000, 'description' => 'Obat anti inflamasi non steroid'],
            ['name' => 'Cetirizine 10mg', 'code' => 'MED-004', 'type' => 'Tablet', 'stock' => 120, 'price' => 6000, 'description' => 'Obat alergi'],
            ['name' => 'OBH Combi Plus', 'code' => 'MED-005', 'type' => 'Sirup', 'stock' => 30, 'price' => 25000, 'description' => 'Obat batuk dan flu'],
        ];

        foreach ($medicines as $med) {
            \App\Models\Medicine::create($med);
        }
    }
}
