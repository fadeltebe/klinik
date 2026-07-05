<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Appointment;
use App\Models\PatientProfile;
use Illuminate\Support\Facades\Auth;

class AppointmentHistory extends Component
{
    use WithPagination;

    public $profileId = '';
    public $status = '';
    public $dateRange = '';

    public function updating($field)
    {
        if (in_array($field, ['profileId', 'status', 'dateRange'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $profiles = PatientProfile::where('user_id', Auth::id())->get();
        $profileIds = $profiles->pluck('id')->toArray();

        $query = Appointment::with(['patientProfile', 'doctor.polyclinic', 'service'])
            ->whereIn('patient_profile_id', $profileIds);

        if ($this->profileId) {
            $query->where('patient_profile_id', $this->profileId);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->dateRange === 'upcoming') {
            $query->where('appointment_date', '>=', now()->format('Y-m-d'))
                  ->whereNotIn('status', ['completed', 'cancelled']);
        } elseif ($this->dateRange === 'past') {
            $query->where(function($q) {
                $q->where('appointment_date', '<', now()->format('Y-m-d'))
                  ->orWhereIn('status', ['completed', 'cancelled']);
            });
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('queue_number', 'asc')
            ->paginate(10);

        return view('livewire.patient.appointment-history', [
            'appointments' => $appointments,
            'profiles' => $profiles,
        ])->layout('layouts.patient');
    }
}
