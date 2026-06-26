<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin')]
class QueueManager extends Component
{
    public $selectedDoctorId = null;
    public $doctors = [];
    public $isGlobalAdmin = false;
    
    // UI state
    public $activeTab = 'pending'; // 'pending' or 'active'

    public function mount()
    {
        $user = Auth::user();
        $doctorAdmin = $user->doctorAdmins->first();

        if ($doctorAdmin && $doctorAdmin->doctor_id) {
            // Restricted to specific doctor
            $this->isGlobalAdmin = false;
            $this->selectedDoctorId = $doctorAdmin->doctor_id;
            $this->doctors = Doctor::where('id', $this->selectedDoctorId)->get();
        } else {
            // Global admin
            $this->isGlobalAdmin = true;
            $this->doctors = Doctor::with('polyclinic')->where('is_active', true)->get();
            if ($this->doctors->count() > 0) {
                $this->selectedDoctorId = $this->doctors->first()->id;
            }
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // Approve Appointment
    public function approve($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        if ($appointment && $appointment->status === 'pending') {
            $appointment->update([
                'status' => 'approved',
                'booked_by_admin_id' => Auth::id()
            ]);
            session()->flash('success', 'Janji temu berhasil disetujui.');
        }
    }

    // Reject Appointment
    public function reject($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        if ($appointment && $appointment->status === 'pending') {
            $appointment->update([
                'status' => 'cancelled',
                'cancellation_reason' => 'Ditolak oleh Admin',
                'booked_by_admin_id' => Auth::id()
            ]);
            session()->flash('success', 'Janji temu telah ditolak.');
        }
    }

    // Update Status
    public function updateStatus($appointmentId, $newStatus)
    {
        $allowedTransitions = [
            'approved' => 'checked_in',    // Pasien Hadir
            'checked_in' => 'calling',     // Panggil Pasien
            'calling' => 'processing',     // Masuk Ruangan / Diperiksa
            'processing' => 'completed',   // Selesai
        ];

        $appointment = Appointment::find($appointmentId);
        
        if ($appointment && isset($allowedTransitions[$appointment->status]) && $allowedTransitions[$appointment->status] === $newStatus) {
            $appointment->update(['status' => $newStatus]);
            session()->flash('success', "Status antrean berhasil diperbarui.");
        }
    }

    public function render()
    {
        $today = Carbon::today();

        $pendingAppointments = [];
        $activeAppointments = [];

        if ($this->selectedDoctorId) {
            // Fetch Pending Approvals for Today
            $pendingAppointments = Appointment::with('patientProfile')
                ->where('doctor_id', $this->selectedDoctorId)
                ->whereDate('appointment_date', $today)
                ->where('status', 'pending')
                ->orderBy('created_at', 'asc')
                ->get();

            // Fetch Active Queue for Today
            $activeAppointments = Appointment::with('patientProfile')
                ->where('doctor_id', $this->selectedDoctorId)
                ->whereDate('appointment_date', $today)
                ->whereIn('status', ['approved', 'checked_in', 'calling', 'processing'])
                ->orderBy('queue_number', 'asc')
                ->get();
        }

        return view('livewire.admin.queue-manager', [
            'pendingAppointments' => $pendingAppointments,
            'activeAppointments' => $activeAppointments,
        ]);
    }
}
