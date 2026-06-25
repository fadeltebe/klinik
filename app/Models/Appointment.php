<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['patient_profile_id', 'doctor_id', 'booked_by_admin_id', 'appointment_date', 'queue_number', 'estimated_service_time', 'status', 'notes', 'cancellation_reason'])]
class Appointment extends Model
{
    public function patientProfile()
    {
        return $this->belongsTo(PatientProfile::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bookedByAdmin()
    {
        return $this->belongsTo(User::class, 'booked_by_admin_id');
    }
}
