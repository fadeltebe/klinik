<?php

namespace Tests\Feature;

use App\Livewire\Patient\BookAppointment;
use App\Models\Doctor;
use App\Models\DoctorService;
use App\Models\PatientProfile;
use App\Models\Polyclinic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PatientBookingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_select_a_doctor_service_when_booking(): void
    {
        $user = User::factory()->create();
        $patientProfile = PatientProfile::create([
            'user_id' => $user->id,
            'full_name' => 'Budi Santoso',
            'nik' => '3201010101010001',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone' => '081234567890',
            'address' => 'Bandung',
        ]);

        $polyclinic = Polyclinic::create([
            'name' => 'Poliklinik Gigi',
            'description' => 'Spesialis gigi',
            'icon' => 'stethoscope',
        ]);

        $doctor = Doctor::create([
            'user_id' => null,
            'polyclinic_id' => $polyclinic->id,
            'name' => 'Dr. Sari',
            'specialization' => 'Dokter Gigi',
            'license_number' => '12345',
            'is_active' => true,
        ]);

        $service = DoctorService::create([
            'doctor_id' => $doctor->id,
            'name' => 'Tambal Gigi',
            'description' => 'Perbaikan gigi berlubang',
            'estimated_duration_minutes' => 30,
            'is_active' => true,
        ]);

        session(['active_profile_id' => $patientProfile->id]);

        Livewire::test(BookAppointment::class)
            ->set('appointmentDate', '2026-07-06')
            ->set('polyclinicId', $polyclinic->id)
            ->set('doctorId', $doctor->id)
            ->set('serviceId', $service->id)
            ->set('complaint', 'Gigi terasa ngilu dan sakit saat mengunyah')
            ->call('submit')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'patient_profile_id' => $patientProfile->id,
            'doctor_id' => $doctor->id,
            'service_id' => $service->id,
            'service_name' => 'Tambal Gigi',
        ]);
    }
}
