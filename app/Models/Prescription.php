<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'status',
        'notes',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)
                    ->withPivot('quantity', 'instructions')
                    ->withTimestamps();
    }
}
