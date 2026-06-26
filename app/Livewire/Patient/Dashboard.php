<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PatientProfile;
use App\Models\Appointment;

#[Layout('layouts.patient')]
class Dashboard extends Component
{
    public $activeProfile;
    public $upcomingAppointments = [];

    public function mount()
    {
        $profileId = session('active_profile_id');
        if (!$profileId) {
            return redirect()->route('patient.profiles.index');
        }

        $this->activeProfile = PatientProfile::where('user_id', auth()->id())->find($profileId);

        if (!$this->activeProfile) {
            return redirect()->route('patient.profiles.index');
        }

        $this->upcomingAppointments = Appointment::where('patient_profile_id', $this->activeProfile->id)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with(['doctor.polyclinic'])
            ->orderBy('appointment_date', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.patient.dashboard');
    }
}
