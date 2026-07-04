<?php

namespace App\Livewire\TvDisplay;

use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class QueueDisplay extends Component
{
    public $activeAppointment = null;
    public $nextAppointments = [];
    #[\Livewire\Attributes\Url(as: 'doctor_id')]
    public $doctor_id = null;

    public function mount()
    {
        $this->loadQueueData();
    }

    public function loadQueueData()
    {
        // Dukung dua skema status: original ('in_queue','in_service')
        // dan skema Admin QueueManager ('approved','checked_in','calling','processing')
        $queuedStatuses = ['in_queue', 'approved', 'checked_in', 'calling'];
        $activeStatuses = ['in_service', 'processing', 'calling'];

        $query = Appointment::with(['patientProfile', 'doctor.polyclinic'])
            ->where(function ($q) use ($queuedStatuses, $activeStatuses) {
                $q->whereIn('status', array_merge($queuedStatuses, $activeStatuses));
            })
            ->orderBy('queue_number', 'asc')
            ->orderBy('appointment_date', 'asc');

        // Filter by doctor jika ada
        if ($this->doctor_id) {
            $query->where('doctor_id', $this->doctor_id);
        }

        $appointments = $query->get();

        // Tentukan appointment aktif berdasarkan prioritas status
        // Prioritas: processing / in_service -> calling -> first queued
        $this->activeAppointment = $appointments
            ->whereIn('status', ['processing', 'in_service'])
            ->first()
            ?? $appointments->where('status', 'calling')->first()
            ?? $appointments->first();

        // Next appointments adalah 5 appointment setelah yang aktif
        if ($this->activeAppointment) {
            $activeIndex = $appointments->search(function ($item) {
                return $item->id === $this->activeAppointment->id;
            });

            $this->nextAppointments = $appointments
                ->slice($activeIndex + 1, 5)
                ->values()
                ->toArray();

            // Convert activeAppointment to array for consistent view access
            $this->activeAppointment = $this->activeAppointment->toArray();
        } else {
            $this->nextAppointments = [];
            $this->activeAppointment = null;
        }
    }

    public function render()
    {
        return view('livewire.tv-display.queue-display');
    }
}
