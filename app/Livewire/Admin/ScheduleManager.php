<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\DoctorSchedule;
use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin')]
class ScheduleManager extends Component
{
    public $isGlobalAdmin = false;
    public $doctors = [];
    
    // Filter for viewing schedule list
    public $selectedDoctorId = null;

    // Form fields
    public $formDoctorId = null;
    public $schedule_date;
    public $start_time = '08:00';
    public $end_time = '12:00';
    public $quota = 20;
    public $interval_minutes = 15;

    protected $rules = [
        'formDoctorId' => 'required|exists:doctors,id',
        'schedule_date' => 'required|date|after_or_equal:today',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'quota' => 'required|integer|min:1',
        'interval_minutes' => 'required|integer|min:5',
    ];

    public function mount(Doctor $doctor)
    {
        $user = Auth::user();
        $doctorAdmin = $user->doctorAdmins->first();

        // Check if admin has access to this doctor
        if ($doctorAdmin && $doctorAdmin->doctor_id && $doctorAdmin->doctor_id !== $doctor->id) {
            abort(403, 'Unauthorized action.');
        }

        $this->isGlobalAdmin = ($doctorAdmin && $doctorAdmin->doctor_id) ? false : true;
        
        $this->doctors = collect([$doctor]); // Wrap in collection for view compatibility if needed
        $this->selectedDoctorId = $doctor->id;
        $this->formDoctorId = $doctor->id;
        
        $this->schedule_date = Carbon::tomorrow()->format('Y-m-d');
    }

    public function saveSchedule()
    {
        $this->validate();

        // Check if schedule already exists for this doctor on this date
        $exists = DoctorSchedule::where('doctor_id', $this->formDoctorId)
            ->where('schedule_date', $this->schedule_date)
            ->exists();
            
        if ($exists) {
            session()->flash('error', 'Jadwal dokter pada tanggal tersebut sudah ada.');
            return;
        }

        DoctorSchedule::create([
            'doctor_id' => $this->formDoctorId,
            'schedule_date' => $this->schedule_date,
            'start_time' => $this->start_time . ':00',
            'end_time' => $this->end_time . ':00',
            'quota' => $this->quota,
            'interval_minutes' => $this->interval_minutes,
            'is_active' => true,
        ]);

        session()->flash('success', 'Jadwal baru berhasil ditambahkan.');
        
        // Reset some form fields
        $this->schedule_date = Carbon::parse($this->schedule_date)->addDay()->format('Y-m-d');
    }

    public function deleteSchedule($id)
    {
        $schedule = DoctorSchedule::find($id);
        
        if ($schedule) {
            // Check if there are active appointments for this doctor on this date
            $hasAppointments = Appointment::where('doctor_id', $schedule->doctor_id)
                ->where('appointment_date', $schedule->schedule_date)
                ->whereNotIn('status', ['cancelled'])
                ->exists();
                
            if ($hasAppointments) {
                session()->flash('error', 'Gagal menghapus! Sudah ada pasien yang mendaftar pada jadwal ini.');
                return;
            }
            
            $schedule->delete();
            session()->flash('success', 'Jadwal berhasil dihapus.');
        }
    }

    public function render()
    {
        $schedules = [];
        
        if ($this->selectedDoctorId) {
            $schedules = DoctorSchedule::with('doctor')
                ->where('doctor_id', $this->selectedDoctorId)
                ->where('schedule_date', '>=', Carbon::today())
                ->orderBy('schedule_date', 'asc')
                ->get();
        }

        return view('livewire.admin.schedule-manager', [
            'schedules' => $schedules
        ]);
    }
}
