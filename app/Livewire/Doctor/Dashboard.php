<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.doctor.dashboard');
    }
}
