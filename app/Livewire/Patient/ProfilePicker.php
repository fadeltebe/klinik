<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PatientProfile;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.patient')]
class ProfilePicker extends Component
{
    public $profiles;

    public function mount()
    {
        $this->profiles = PatientProfile::where('user_id', Auth::id())->get();
    }

    public function selectProfile($profileId)
    {
        session(['active_profile_id' => $profileId]);
        return redirect()->route('patient.dashboard');
    }

    public function render()
    {
        return view('livewire.patient.profile-picker');
    }
}
