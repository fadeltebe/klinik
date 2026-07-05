<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['doctor_id', 'name', 'description', 'estimated_duration_minutes', 'price', 'is_active'])]
class DoctorService extends Model
{
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
