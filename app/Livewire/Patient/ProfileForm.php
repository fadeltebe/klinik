<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PatientProfile;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.patient')]
class ProfileForm extends Component
{
    public ?PatientProfile $profile = null;
    public $isEdit = false;

    public $full_name;
    public $nik;
    public $date_of_birth;
    public $gender;
    public $phone;
    public $address;
    public $blood_type;
    public $allergies;

    public function mount(PatientProfile $profile = null)
    {
        if ($profile && $profile->exists) {
            if ($profile->user_id !== Auth::id()) {
                abort(403);
            }
            $this->profile = $profile;
            $this->isEdit = true;

            $this->full_name = $profile->full_name;
            $this->nik = $profile->nik;
            $this->date_of_birth = $profile->date_of_birth;
            $this->gender = $profile->gender;
            $this->phone = $profile->phone;
            $this->address = $profile->address;
            $this->blood_type = $profile->blood_type;
            $this->allergies = $profile->allergies;
        }
    }

    public function save()
    {
        $rules = [
            'full_name' => 'required|min:3',
            'nik' => 'required|digits:16|unique:patient_profiles,nik' . ($this->isEdit ? ',' . $this->profile->id : ''),
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'phone' => 'nullable|regex:/^08[0-9]{8,13}$/',
            'address' => 'nullable|string',
            'blood_type' => 'nullable|in:A,B,AB,O',
            'allergies' => 'nullable|string',
        ];

        $validatedData = $this->validate($rules);
        $validatedData['user_id'] = Auth::id();

        if ($this->isEdit) {
            $this->profile->update($validatedData);
        } else {
            PatientProfile::create($validatedData);
        }

        return redirect()->route('patient.profiles.index');
    }

    public function render()
    {
        return view('livewire.patient.profile-form');
    }
}
