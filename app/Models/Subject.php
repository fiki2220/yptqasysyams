<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Mapel punya banyak pertemuan
    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    // Mapel punya banyak nilai siswa
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}