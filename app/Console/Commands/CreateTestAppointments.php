<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\PatientProfile;
use App\Models\Doctor;
use Carbon\Carbon;

class CreateTestAppointments extends Command
{
    protected $signature = 'appointments:create-test {count=10 : Number of test appointments}';
    protected $description = 'Create test appointments for TV Display testing';

    public function handle()
    {
        $count = $this->argument('count');

        // Get available doctors and patient profiles
        $doctors = Doctor::all();
        $profiles = PatientProfile::all();

        if ($doctors->isEmpty() || $profiles->isEmpty()) {
            $this->error('Please seed doctors and patient profiles first!');
            $this->line('Run: php artisan db:seed');
            return 1;
        }

        $statuses = ['in_queue', 'in_service'];
        $queueNumber = 1;

        for ($i = 0; $i < $count; $i++) {
            $appointment = Appointment::create([
                'patient_profile_id' => $profiles->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->addHours(rand(0, 24)),
                'queue_number' => $queueNumber++,
                'estimated_service_time' => rand(15, 60),
                'status' => $i === 0 ? 'in_service' : ($i < 6 ? 'in_queue' : 'pending'),
                'notes' => "Test appointment #{$i}",
            ]);

            $this->line("✓ Created appointment #{$appointment->id} - Queue: {$appointment->queue_number} - Status: {$appointment->status}");
        }

        $this->info("\n✅ Created {$count} test appointments successfully!");
        $this->line("Access TV Display at: http://localhost:8000/tv-display");
    }
}
