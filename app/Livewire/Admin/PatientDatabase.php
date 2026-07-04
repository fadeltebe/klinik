<?php

namespace App\Livewire\Admin;

use App\Models\PatientProfile;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class PatientDatabase extends Component
{
    public string $search = '';

    public function render()
    {
        $query = PatientProfile::with('user')->latest();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $patients = $query->get();

        return view('livewire.admin.patient-database', compact('patients'));
    }
}
