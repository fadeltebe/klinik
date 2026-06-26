<?php

namespace App\Livewire\Apotek;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.apotek.dashboard');
    }
}
