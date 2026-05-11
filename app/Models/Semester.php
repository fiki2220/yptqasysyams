<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
        'tuition_fee',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'tuition_fee' => 'decimal:2',
    ];

    // Semester punya banyak data nilai siswa
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // Semester punya banyak data pembayaran
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}