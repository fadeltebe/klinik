<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin')]
class DoctorList extends Component
{
    public function render()
    {
        $user = Auth::user();
        $doctorAdmin = $user->doctorAdmins->first();

        if ($doctorAdmin && $doctorAdmin->doctor_id) {
            $doctors = Doctor::with('polyclinic')
                ->where('id', $doctorAdmin->doctor_id)
                ->get();
        } else {
            $doctors = Doctor::with('polyclinic')->where('is_active', true)->get();
        }

        return view('livewire.admin.doctor-list', [
            'doctors' => $doctors
        ]);
    }
}
