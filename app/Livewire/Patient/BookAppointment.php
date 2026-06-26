<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Polyclinic;
use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.patient')]
class BookAppointment extends Component
{
    public $activeProfileId;
    public $step = 1;
    
    public $appointmentDate;
    public $polyclinicId;
    public $doctorId;

    public $polyclinics = [];
    public $doctors = [];
    public $availableDates = [];

    public function mount()
    {
        $this->activeProfileId = session('active_profile_id');
        if (!$this->activeProfileId) {
            return redirect()->route('patient.profiles.index');
        }

        // Generate next 7 days for booking
        $this->availableDates = collect(range(0, 7))->map(function($days) {
            $date = Carbon::now()->addDays($days);
            // Skip Sunday
            if ($date->isSunday()) return null;
            return [
                'value' => $date->format('Y-m-d'),
                'label' => $date->isToday() ? 'Hari Ini' : ($date->isTomorrow() ? 'Besok' : $date->isoFormat('dddd, D MMM')),
            ];
        })->filter()->values()->toArray();

        $this->polyclinics = Polyclinic::all();
    }

    public function updatedPolyclinicId()
    {
        $this->doctorId = null;
        if ($this->polyclinicId) {
            $this->doctors = Doctor::where('polyclinic_id', $this->polyclinicId)
                ->where('is_active', true)
                ->get();
        } else {
            $this->doctors = [];
        }
    }

    public function nextStep()
    {
        if ($this->step == 1) {
            $this->validate([
                'appointmentDate' => 'required|date',
                'polyclinicId' => 'required|exists:polyclinics,id',
                'doctorId' => 'required|exists:doctors,id',
            ], [
                'appointmentDate.required' => 'Pilih tanggal berobat.',
                'polyclinicId.required' => 'Pilih poli tujuan.',
                'doctorId.required' => 'Pilih dokter.',
            ]);
            $this->step = 2;
        }
    }

    public function submit()
    {
        // Double check validation
        $this->validate([
            'appointmentDate' => 'required|date',
            'polyclinicId' => 'required|exists:polyclinics,id',
            'doctorId' => 'required|exists:doctors,id',
        ]);

        // Check if already booked for the same day and doctor
        $exists = Appointment::where('patient_profile_id', $this->activeProfileId)
            ->where('doctor_id', $this->doctorId)
            ->whereDate('appointment_date', $this->appointmentDate)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($exists) {
            session()->flash('error', 'Anda sudah memiliki janji temu dengan dokter ini pada tanggal tersebut.');
            $this->step = 1;
            return;
        }

        DB::beginTransaction();
        try {
            // Logic for queue number
            $lastQueue = Appointment::where('doctor_id', $this->doctorId)
                ->whereDate('appointment_date', $this->appointmentDate)
                ->max('queue_number');
                
            $newQueue = $lastQueue ? $lastQueue + 1 : 1;

            Appointment::create([
                'patient_profile_id' => $this->activeProfileId,
                'doctor_id' => $this->doctorId,
                'appointment_date' => $this->appointmentDate,
                'queue_number' => $newQueue,
                'status' => 'pending', // Menunggu konfirmasi dari admin klinik
            ]);

            DB::commit();
            
            session()->flash('success', 'Janji temu berhasil dibuat! Silakan tunggu konfirmasi.');
            return redirect()->route('patient.dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.patient.book-appointment');
    }
}
