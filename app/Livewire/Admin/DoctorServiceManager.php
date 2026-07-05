<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Doctor;
use App\Models\DoctorService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admin')]
class DoctorServiceManager extends Component
{
    public $doctor;
    public $services = [];

    public $name;
    public $description;
    public $estimated_duration_minutes = 30;
    public $price;
    public $is_active = true;
    public $serviceId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'estimated_duration_minutes' => 'nullable|integer|min:1',
        'price' => 'nullable|numeric|min:0',
        'is_active' => 'boolean',
    ];

    public function mount(Doctor $doctor)
    {
        $user = Auth::user();
        $doctorAdmin = $user->doctorAdmins->first();

        if ($doctorAdmin && $doctorAdmin->doctor_id && $doctorAdmin->doctor_id !== $doctor->id) {
            abort(403, 'Unauthorized action.');
        }

        $this->doctor = $doctor;
        $this->loadServices();
    }

    public function loadServices()
    {
        $this->services = DoctorService::where('doctor_id', $this->doctor->id)
            ->orderBy('name')
            ->get();
    }

    public function saveService()
    {
        $this->validate();

        if ($this->serviceId) {
            $service = DoctorService::find($this->serviceId);

            if ($service) {
                $service->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'estimated_duration_minutes' => $this->estimated_duration_minutes,
                    'price' => $this->price,
                    'is_active' => $this->is_active,
                ]);

                session()->flash('success', 'Layanan berhasil diperbarui.');
            }
        } else {
            DoctorService::create([
                'doctor_id' => $this->doctor->id,
                'name' => $this->name,
                'description' => $this->description,
                'estimated_duration_minutes' => $this->estimated_duration_minutes,
                'price' => $this->price,
                'is_active' => $this->is_active,
            ]);

            session()->flash('success', 'Layanan baru berhasil ditambahkan.');
        }

        $this->resetForm();
        $this->loadServices();
    }

    public function editService($id)
    {
        $service = DoctorService::find($id);

        if (! $service) {
            return;
        }

        $this->serviceId = $service->id;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->estimated_duration_minutes = $service->estimated_duration_minutes ?? 30;
        $this->price = $service->price;
        $this->is_active = $service->is_active;
    }

    public function deleteService($id)
    {
        $service = DoctorService::find($id);

        if (! $service) {
            return;
        }

        $service->delete();
        session()->flash('success', 'Layanan berhasil dihapus.');
        $this->loadServices();
    }

    public function resetForm()
    {
        $this->serviceId = null;
        $this->name = null;
        $this->description = null;
        $this->estimated_duration_minutes = 30;
        $this->price = null;
        $this->is_active = true;
    }

    public function render()
    {
        return view('livewire.admin.doctor-service-manager');
    }
}
