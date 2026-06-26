<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Appointment;
use Illuminate\Support\Carbon;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $stats = [
            'pending' => Appointment::whereDate('appointment_date', $today)->where('status', 'pending')->count(),
            'approved' => Appointment::whereDate('appointment_date', $today)->where('status', 'approved')->count(),
            'completed' => Appointment::whereDate('appointment_date', $today)->where('status', 'completed')->count(),
            'total' => Appointment::whereDate('appointment_date', $today)->count(),
        ];

        return view('livewire.admin.dashboard', compact('stats'));
    }
}
