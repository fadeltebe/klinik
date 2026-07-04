<?php

namespace Tests\Feature;

use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPatientDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_registered_patient_database(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $patientUser = User::factory()->create(['role' => 'patient']);

        $patientProfile = PatientProfile::create([
            'user_id' => $patientUser->id,
            'full_name' => 'Siti Aminah',
            'nik' => '3201010101010001',
            'date_of_birth' => '1995-01-01',
            'gender' => 'female',
            'phone' => '081234567890',
            'address' => 'Bandung',
            'blood_type' => 'O',
            'allergies' => 'Tidak ada',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.patients.index'));

        $response->assertStatus(200);
        $response->assertSee($patientProfile->full_name);
        $response->assertSee($patientProfile->nik);
    }
}
