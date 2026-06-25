<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'name', 'specialization', 'poli_name', 'license_number', 'photo', 'is_active'])]
class Doctor extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctorAdmins()
    {
        return $this->hasMany(DoctorAdmin::class);
    }

    public function doctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
