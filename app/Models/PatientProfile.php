<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'full_name', 'nik', 'date_of_birth', 'gender', 'phone', 'address', 'blood_type', 'allergies'])]
class PatientProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
