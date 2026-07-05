<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Polyclinic;
use App\Models\Doctor;
use App\Models\DoctorService;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

#[Layout('layouts.patient')]
class BookAppointment extends Component
{
    public $activeProfileId;
    public $step = 1;

    public $appointmentDate;
    public $polyclinicId;
    public $doctorId;
    public $serviceId;
    public $serviceName;
    public $complaint;

    public $polyclinics = [];
    public $doctors = [];
    public $services = [];
    public $availableDates = [];

    public function mount()
    {
        $this->activeProfileId = session('active_profile_id');
        if (!$this->activeProfileId) {
            return redirect()->route('patient.profiles.index');
        }

        // Generate next 7 days for booking
        $this->availableDates = collect(range(0, 7))->map(function ($days) {
            $date = Carbon::now()->addDays($days);
            // Skip Sunday
            if ($date->isSunday()) return null;

            // Set locale to Indonesian
            $dayName = $date->locale('id')->isoFormat('dddd');
            $dateFormatted = $date->locale('id')->isoFormat('D MMMM Y');

            if ($date->isToday()) {
                $label = 'Hari Ini, ' . $dateFormatted;
            } elseif ($date->isTomorrow()) {
                $label = 'Besok, ' . $dateFormatted;
            } else {
                $label = $dayName . ', ' . $dateFormatted;
            }

            return [
                'value' => $date->format('Y-m-d'),
                'label' => $label,
            ];
        })->filter()->values()->toArray();

        $this->polyclinics = Polyclinic::all();
    }

    public function updatedPolyclinicId()
    {
        $this->doctorId = null;
        $this->serviceId = null;
        $this->serviceName = null;
        if ($this->polyclinicId) {
            $this->doctors = Doctor::where('polyclinic_id', $this->polyclinicId)
                ->where('is_active', true)
                ->get();
        } else {
            $this->doctors = [];
        }
    }

    public function updatedDoctorId()
    {
        $this->serviceId = null;
        $this->serviceName = null;
        if ($this->doctorId) {
            $this->services = DoctorService::where('doctor_id', $this->doctorId)
                ->where('is_active', true)
                ->get();
        } else {
            $this->services = [];
        }
    }

    public function updatedServiceId()
    {
        $this->serviceName = $this->serviceId
            ? DoctorService::find($this->serviceId)?->name
            : null;
    }

    public function nextStep()
    {
        if ($this->step == 1) {
            $this->validate([
                'appointmentDate' => 'required|date_format:Y-m-d',
            ], [
                'appointmentDate.required' => 'Pilih tanggal berobat.',
            ]);
            $this->step = 2;
        } elseif ($this->step == 2) {
            $this->validate([
                'polyclinicId' => 'required|exists:polyclinics,id',
            ], [
                'polyclinicId.required' => 'Pilih poli tujuan.',
            ]);

            $this->doctors = Doctor::where('polyclinic_id', $this->polyclinicId)
                ->where('is_active', true)
                ->get();

            $this->step = 3;
        } elseif ($this->step == 3) {
            $this->validate([
                'doctorId' => 'required|exists:doctors,id',
            ], [
                'doctorId.required' => 'Pilih dokter.',
            ]);

            $this->serviceId = null;
            $this->serviceName = null;
            $this->services = DoctorService::where('doctor_id', $this->doctorId)
                ->where('is_active', true)
                ->get();

            $this->step = 4;
        } elseif ($this->step == 4) {
            $this->validate([
                'serviceId' => [
                    'required',
                    Rule::exists('doctor_services', 'id')->where('doctor_id', $this->doctorId),
                ],
            ], [
                'serviceId.required' => 'Pilih layanan yang dibutuhkan.',
                'serviceId.exists' => 'Layanan yang dipilih tidak tersedia untuk dokter ini.',
            ]);
            $this->step = 5;
        } elseif ($this->step == 5) {
            $this->validate([
                'complaint' => 'required|string|min:10|max:500',
            ], [
                'complaint.required' => 'Jelaskan keluhan Anda.',
                'complaint.min' => 'Keluhan minimal 10 karakter.',
                'complaint.max' => 'Keluhan maksimal 500 karakter.',
            ]);
            $this->step = 6;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step -= 1;
        }
    }

    public function submit()
    {
        \Log::info('Submit values: ', [
            'appointmentDate' => $this->appointmentDate,
            'polyclinicId' => $this->polyclinicId,
            'doctorId' => $this->doctorId,
            'serviceId' => $this->serviceId,
            'complaint' => $this->complaint,
        ]);
        // Double check validation
        $this->validate([
            'appointmentDate' => 'required|date_format:Y-m-d',
            'polyclinicId' => 'required|exists:polyclinics,id',
            'doctorId' => 'required|exists:doctors,id',
            'serviceId' => [
                'required',
                Rule::exists('doctor_services', 'id')->where('doctor_id', $this->doctorId),
            ],
            'complaint' => 'required|string|min:10|max:500',
        ], [
            'serviceId.exists' => 'Layanan yang dipilih tidak tersedia untuk dokter ini.',
            'appointmentDate.required' => 'Pilih tanggal berobat.',
            'polyclinicId.required' => 'Pilih poli tujuan.',
            'doctorId.required' => 'Pilih dokter.',
            'serviceId.required' => 'Pilih layanan yang dibutuhkan.',
            'complaint.required' => 'Jelaskan keluhan Anda.',
            'complaint.min' => 'Keluhan minimal 10 karakter.',
            'complaint.max' => 'Keluhan maksimal 500 karakter.',
        ]);

        $this->serviceName = $this->serviceId
            ? DoctorService::find($this->serviceId)?->name
            : null;

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
                'service_id' => $this->serviceId,
                'service_name' => $this->serviceName,
                'appointment_date' => $this->appointmentDate,
                'queue_number' => $newQueue,
                'status' => 'pending',
                'complaint' => $this->complaint,
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
