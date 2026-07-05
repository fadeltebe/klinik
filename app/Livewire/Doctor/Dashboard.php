<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $doctorId;

    public function mount()
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();
        if ($doctor) {
            $this->doctorId = $doctor->id;
        }
    }

    public function callPatient($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        if ($appointment && $appointment->doctor_id == $this->doctorId) {
            // Jika ada pasien lain yang sedang dipanggil, jangan ubah otomatis, atau biarkan dokter yang mengatur.
            // Namun idealnya, panggil 1 per 1.
            $appointment->update(['status' => 'calling']);
        }
    }

    public function processPatient($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        if ($appointment && $appointment->doctor_id == $this->doctorId) {
            $appointment->update(['status' => 'processing']);
        }
    }

    public function completePatient($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        if ($appointment && $appointment->doctor_id == $this->doctorId) {
            $appointment->update(['status' => 'completed']);
        }
    }

    public function render()
    {
        $today = now()->format('Y-m-d');
        
        $appointments = collect();
        $stats = [
            'total' => 0,
            'completed' => 0,
            'remaining' => 0,
        ];

        if ($this->doctorId) {
            $appointments = Appointment::with(['patientProfile', 'service'])
                ->where('doctor_id', $this->doctorId)
                ->where('appointment_date', $today)
                ->whereNotIn('status', ['pending', 'cancelled']) // Hanya tampilkan yang sudah di-approve ke atas
                ->orderBy('queue_number', 'asc')
                ->get();

            $stats['total'] = $appointments->count();
            $stats['completed'] = $appointments->where('status', 'completed')->count();
            $stats['remaining'] = $stats['total'] - $stats['completed'];
        }

        return view('livewire.doctor.dashboard', [
            'appointments' => $appointments,
            'stats' => $stats,
        ])->layout('layouts.doctor');
    }
}
