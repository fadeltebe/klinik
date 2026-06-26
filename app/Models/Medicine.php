<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'stock',
        'price',
        'description',
    ];

    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class)
                    ->withPivot('quantity', 'instructions')
                    ->withTimestamps();
    }
}
