<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['doctor_id', 'schedule_date', 'start_time', 'end_time', 'quota', 'interval_minutes', 'is_active'])]
class DoctorSchedule extends Model
{
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
